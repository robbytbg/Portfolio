# Data Cleaning

1. Memuat Data:
   - Saya memulai dengan menggunakan Pandas untuk memuat dataset FIFA21 dari file CSV.
   - Untuk mendapatkan perspektif awal, periksa lima baris pertama menggunakan `data.head(5)`.
   - Untuk meningkatkan pemahaman, saya menggunakan `data.info()` untuk memeriksa tipe data dan nilai yang hilang.

```python
import pandas as pd
data=pd.read_csv('/content/fifa21 raw data v2.csv')
```

```python
data.info()
```
![alt text](https://github.com/robbytbg/Port2/blob/main/Data%20Cleaning/related%20images/DataCleaning1.PNG)

2. Kolom untuk Dikelola:
   - Pada indeks 3, 4, dan 18, kolom yang tidak perlu dihapus dengan bantuan `data.drop(data.columns[[3, 4, 18]], axis=1, inplace=True)`.
   - Menggunakan nol untuk mengisi nilai yang hilang pada kolom "Hits": `data['Hits'].fillna(0, inplace=True)`.

![alt text](https://github.com/robbytbg/Port2/blob/main/Data%20Cleaning/related%20images/DataCleaning2.PNG)

3. Pemformatan dan Pemberian Nama Kolom:
   - Menggunakan `data=data.rename(columns={'LongName':'FullName'})` untuk mengganti nama kolom 'LongName' menjadi 'FullName'.
   - Mengubah format kolom 'Joined' menjadi format datetime ('YYYY-MM-DD').
   - Kolom '↓OVA' telah diubah nama menjadi 'OVA'.
   - Karakter yang tidak perlu dihilangkan dari kolom 'Club'.

```python
data['Joined'] = pd.to_datetime(data['Joined'], format='%b %d, %Y')

data['Joined'] = data['Joined'].dt.strftime('%Y-%m-%d')
```

4. Mengelola Status Pemain:
   - Kolom 'on_loan' dan 'free' ditambahkan untuk mencatat beberapa status pemain.
   - Berdasarkan indikator status yang diperbarui, mengubah kolom 'Status'.

```python
data['on_loan'] = data['Joined'].str.contains('On Loan')

data['free'] = data['Joined'].str.contains('Free')

data['Joined'] = data['Joined'].str.replace('On Loan', '').str.replace('Free', '').str.strip()

data['Status'] = 'active'
data.loc[data['on_loan'], 'Status'] = 'on loan'
data.loc[data['free'], 'Status'] = 'free'
```

5. Mengatur Ulang Kolom:
   - Kolom diatur ulang untuk meningkatkan keterbacaan.
   - Format kolom 'Contract' disesuaikan.
   - Tiga kolom terakhir dataset dihilangkan.

```python
new_order = list(data.columns[:9]) + ['Status'] + list(data.columns[9:])
data = data[new_order]
data.drop(data.iloc[:,-3:],axis=1,inplace=True)
```

6. Standarisasi Tinggi dan Berat:
    - Mengonversi kolom tinggi dan berat ke satuan tunggal (kilogram untuk berat dan sentimeter untuk tinggi).
  
```python
import re

def convert_height_to_cm(height):
    if 'cm' in height:
        cm_value = int(re.search(r'\d+', height).group())
        return cm_value
    else:
        feet, inches = map(int, re.findall(r'\d+', height))
        total_inches = feet * 12 + inches
        total_centimeters = total_inches * 2.54
        return total_centimeters

data['Height'] = data['Height'].apply(convert_height_to_cm)
```
```python
def convert_weight_to_kg(weight):
    if 'kg' in weight:
        kg_value = int(re.search(r'\d+', weight).group())
        return kg_value
    elif 'lbs' in weight:
        lbs_value = int(re.search(r'\d+', weight).group())
        kg_value = lbs_value * 0.45359237
        return kg_value
```
![alt text](https://github.com/robbytbg/Port2/blob/main/Data%20Cleaning/related%20images/DataCleaning5.PNG)

7. Konversi Nilai Moneter:
   - Mengambil nilai numerik dalam euro untuk kolom "Release Clause," "Wage," dan "Value".

```python
def convert_to_numeric(converto):
    numeric_value = 0  # Nilai default

    if isinstance(converto, str):
        if 'M' in converto:
            match = re.search(r'\d+\.\d+', converto)
            numeric_value = float(match.group()) * 1e6 if match else 0
        elif 'K' in converto:
            match = re.search(r'\d+', converto)
            numeric_value = float(match.group()) * 1e3 if match else 0
    elif isinstance(converto, (int, float)):
        numeric_value = float(converto)

    return '{:.0f}'.format(numeric_value)
```
![alt text](https://github.com/robbytbg/Port2/blob/main/Data%20Cleaning/related%20images/DataCleaning3.PNG)

8. Konsistensi Numerik:
   - Untuk menjamin representasi numerik yang konsisten, simbol bintang dihilangkan dari kolom 'IR', 'SM', dan 'W/F'.
   - Beberapa kolom diubah menjadi bilangan bulat ('Hits', 'W/F', 'SM', 'IR').

```python
data_types = {
    'Value(€)': 'int64',
    'Wage(€)': 'int64',
    'Release Clause(€)': 'int64',
    'Hits': 'int64',
    'W/F': 'int64',
    'SM': 'int64',
    'IR': 'int64'
}

data = data.astype(data_types)
```

9. Pengurutan dan Pembersihan Posisi:
    - Dengan mengurutkan posisi dalam setiap entri secara alfabetis, saya dapat mengurutkan dan membersihkan kolom 'Positions'.

```python
def sort_row(row):
    return ', '.join(sorted(row.split(', ')))

data['Positions'] = data['Positions'].apply(sort_row)
```
![alt text](https://github.com/robbytbg/Port2/blob/main/Data%20Cleaning/related%20images/DataCleaning4.PNG)

10. Menyimpan Data yang Sudah Dibersihkan:
    - Menggunakan `data.to

_csv('cleaned fifa21.csv')` untuk menyimpan dataset yang sudah dibersihkan ke file CSV baru bernama 'cleaned fifa21.csv'.

```python
data.to_csv('cleaned fifa21.csv')
```
