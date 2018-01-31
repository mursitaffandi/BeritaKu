# BeritaKu #
index.php di default url sudah di hapus dengan file .htaccess , sudah di set default controller dan autoload model , menambahkan helper simplehtmldomparser
rss generator from many source with output json, REST API provider
menggunakan framework [Codeigniter v3](https://codeigniter.com/user_guide/)
menerapkan konsep MVP dengan baik ( semua yg berurusan dengan database kodenya di model)
hanya REST API provider tidak ada view

#### Mekanisme ####
function di controller menerima request dengan parameter sumber berita --> function generator RSS to JSON mengambil RSS dalam bentuk XML dengan menggunakan function [cURL](http://php.net/manual/en/ref.curl.php) php [(lihat)](https://github.com/mursyed/BeritaKu/blob/master/SATes/tes.php) --> di parsing dengan [simplehtmldomparser](http://simplehtmldom.sourceforge.net/) --> hasilnya berupa array kemudian di return dalam bentuk json dengan function json_encode 
