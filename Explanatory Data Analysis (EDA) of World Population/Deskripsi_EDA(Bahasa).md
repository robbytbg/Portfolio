# Explanatory Data Analysis

Langkah 1: Investigasi Awal

Untuk memulai, saya memuat dataset `world_population.csv` ke dalam Pandas DataFrame (`df`). Saya melihat lima baris terakhir (`df.tail(5)`), melihat informasi dasar dataset (`df.info()`), dan mendapatkan statistik deskriptif (`df.describe()`) untuk memahami data tersebut. Untuk memastikan kualitas data, saya juga menghitung jumlah nilai unik di setiap kolom (`df.nunique()`) dan mencari nilai yang hilang (`df.isnull().sum()`).

![alt text](https://github.com/robbytbg/Port2/blob/main/Explanatory%20Data%20Analysis/Related%20Images/EDA!.PNG)

Langkah 2: Mengatur dan Mengilustrasikan

Saya mengurutkan DataFrame berdasarkan kolom `World Population Percentage` secara menurun untuk menentukan 10 negara teratas berdasarkan persentase populasi dunia. Daftar hasilnya ditunjukkan di sini (`df.sort_values(by="World Population Percentage", ascending=False)).The head(10)`.

![alt text](https://github.com/robbytbg/Port2/blob/main/Explanatory%20Data%20Analysis/Related%20Images/EDA2.PNG)

Langkah 3: Analisis Korelasi

Untuk menyelidiki hubungan antara berbagai karakteristik numerik, saya membuat peta panas menggunakan matriks korelasi (`sns.heatmap(df.corr(), annot=True)`). Dengan menggunakan alat grafis ini, saya dapat menemukan hubungan dan pola yang mungkin ada.

![alt text](https://github.com/robbytbg/Port2/blob/main/Explanatory%20Data%20Analysis/Related%20Images/eda3.png)

Langkah 4: Analisis berdasarkan Negara (Indonesia)

Saya fokus pada Indonesia dan mencari DataFrame untuk baris yang mengandung kata `Indonesia`. Saya membuat plot garis untuk menunjukkan tren populasi dari waktu ke waktu dengan memilih kolom populasi yang relevan, mentransposisi data untuk memudahkan pembuatan grafik, dan membuat gambar.

![alt text](https://github.com/robbytbg/Port2/blob/main/Explanatory%20Data%20Analysis/Related%20Images/EDA4.png)

Langkah 5: Analisis Lima Negara Teratas

Saya membuat plot batang untuk membandingkan populasi lima negara teratas berdasarkan populasi pada tahun 2022. Ini membuat ukuran relatif negara-negara padat penduduk ini lebih mudah dipahami.

![alt text](https://github.com/robbytbg/Port2/blob/main/Explanatory%20Data%20Analysis/Related%20Images/EDA5.png)

Langkah 6: Analisis berdasarkan Benua

Saya menemukan rata-rata populasi untuk setiap tahun dengan membagi data berdasarkan benua. Selanjutnya, saya membuat plot garis untuk menunjukkan tren populasi di seluruh benua. Selain itu, saya menampilkan distribusi data populasi untuk setiap benua menggunakan boxplot.

![alt text](https://github.com/robbytbg/Port2/blob/main/Explanatory%20Data%20Analysis/Related%20Images/EDA6.png)

Langkah 7: Agregasi Populasi berdasarkan Benua

Saya menggabungkan populasi berdasarkan benua untuk mendapatkan gambaran global. Saya membuat diagram lingkaran untuk menunjukkan bagaimana populasi dunia akan didistribusikan menurut wilayah pada tahun 2022. Penyesuaian kustom meningkatkan daya tarik estetika dan membuatnya lebih mudah dipahami distribusi populasi dunia.

![alt text](https://github.com/robbytbg/Port2/blob/main/Explanatory%20Data%20Analysis/Related%20Images/EDA7.png)
