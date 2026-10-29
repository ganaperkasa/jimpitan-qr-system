import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

/**
 * Komponen pemindai QR. Pustaka html5-qrcode dimuat hanya di halaman scan.
 * Kamera di browser membutuhkan HTTPS (atau localhost) dan izin dari pengguna.
 */
Alpine.data('pemindai', (urlCatat) => ({
    status: 'diam', // diam | memuat | aktif | gagal | selesai
    pesan: '',
    pemindai: null,

    async mulai() {
        if (this.status === 'memuat' || this.status === 'aktif') return;
        this.status = 'memuat';
        this.pesan = '';

        try {
            const { Html5Qrcode } = await import('html5-qrcode');
            this.pemindai = new Html5Qrcode('area-kamera');
            await this.pemindai.start(
                { facingMode: 'environment' },
                { fps: 10, qrbox: { width: 220, height: 220 } },
                (teks) => this.berhasil(teks),
                () => {},
            );
            this.status = 'aktif';
        } catch (galat) {
            this.status = 'gagal';
            const teks = String(galat && (galat.name || galat.message || galat));
            this.pesan = /NotAllowed|Permission/i.test(teks)
                ? 'Izin kamera ditolak. Izinkan kamera di pengaturan browser, atau pakai input kode manual.'
                : 'Kamera tidak tersedia di perangkat ini. Pakai input kode manual di bawah.';
        }
    },

    async berhasil(teks) {
        if (this.status === 'selesai') return;
        this.status = 'selesai';
        try {
            await this.pemindai.stop();
        } catch (e) {
            /* kamera sudah berhenti */
        }
        window.location.href = `${urlCatat}?kode=${encodeURIComponent(String(teks).trim())}`;
    },

    async berhenti() {
        try {
            if (this.pemindai && this.pemindai.isScanning) await this.pemindai.stop();
        } catch (e) {
            /* abaikan */
        }
    },
}));

/** Format ribuan untuk input nominal: 2000 -> 2.000 */
Alpine.data('nominal', (awal = '') => ({
    nilai: awal,
    format(teks) {
        return String(teks).replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    },
    atur(angka) {
        this.nilai = this.format(angka);
    },
}));

Alpine.start();
