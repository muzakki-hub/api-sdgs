CREATE VIEW skor_desa_p3 AS
SELECT 
    IF(nama_kades IS NULL, 0, 11.11) AS skor_nama_kades,
    IF(nik_kades IS NULL, 0, 11.11) AS skor_nik_kades,
    IF(awal_jabatan_kades IS NULL, 0, 11.11) AS skor_awal_jabatan_kades,
    IF(nama_sekdes IS NULL, 0, 11.11) AS skor_nama_sekdes,
    IF(nik_sekdes IS NULL, 0, 11.11) AS skor_nik_sekdes,
    IF(awal_jabatan_sekdes IS NULL, 0, 11.11) AS skor_awal_jabatan_sekdes,
    IF(nama_bendes IS NULL, 0, 11.11) AS skor_nama_bendes,
    IF(nik_bendes IS NULL, 0, 11.11) AS skor_nik_bendes,
    IF(awal_jabatan_bendes IS NULL, 0, 11.11) AS skor_awal_jabatan_bendes,

FROM desa_p3
WHERE id_survey = (
    SELECT id 
    FROM survey 
    WHERE tgl_mulai <= CURDATE() AND tgl_akhir >= CURDATE()
);

CREATE VIEW skor_desa_p5 AS
SELECT 
    IF(rpjm_berlaku = '', 0, 20) AS skor_rpjm_berlaku,
    IF(rkp_desa = '', 0, 20) AS skor_rkp_desa,

FROM desa_p5
WHERE id_survey = (
    SELECT id 
    FROM survey 
    WHERE tgl_mulai <= CURDATE() AND tgl_akhir >= CURDATE()
);

CREATE VIEW skor_desa_p601 AS
SELECT 
    IF(anggaran_pendapatan = '', 0, 10) AS skor_anggaran_pendapatan,
    IF(apbn = '', 0, 10) AS skor_apbn,
    IF(pades = '', 0, 10) AS skor_pades,
    IF(pajak_daerah = '', 0, 10) AS skor_pajak_daerah

FROM desa_p601
WHERE id_survey = (
    SELECT id 
    FROM survey 
    WHERE tgl_mulai <= CURDATE() AND tgl_akhir >= CURDATE()
);
CREATE VIEW skor_desa_p602 AS
SELECT 
    IF(anggaran_pengeluaran = '', 0, 10) AS skor_anggaran_pengeluaran,
    IF(penyelenggaraan_desa = '', 0, 10) AS skor_penyelenggaraan_desa,
    IF(pembangunan_desa = '', 0, 10) AS skor_pembangunan_desa,
    IF(pemberdayaan_desa = '', 0, 10) AS skor_pemberdayaan_desa,
    IF(bina_masyarakat = '', 0, 10) AS skor_bina_masyarakat

FROM desa_p602
WHERE id_survey = (
    SELECT id 
    FROM survey 
    WHERE tgl_mulai <= CURDATE() AND tgl_akhir >= CURDATE()
);

CREATE VIEW skor_desa_p7 AS
SELECT 
    IF(teknologi = '', 0, 25) AS skor_teknologi,
    IF(info_desa = '', 0, 25) AS skor_info_desa,
    IF(nama_pdesa = '', 0, 25) AS skor_nama_pdesa,
    IF(jk_pdesa = '', 0, 25) AS skor_jk_pdesa

FROM desa_p7
WHERE id_survey = (
    SELECT id 
    FROM survey 
    WHERE tgl_mulai <= CURDATE() AND tgl_akhir >= CURDATE()
);