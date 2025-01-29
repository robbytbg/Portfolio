# Machine Learning

Langkah 1: Menyelidiki dan Memuat Data

Saya memulai proyek dengan mengimpor perpustakaan yang diperlukan seperti NumPy, Matplotlib, dan Pandas. Dataset saya, `classification_in_asteroseismology.csv`, dimuat ke dalam DataFrame (`df`) menggunakan Pandas. Data terkait asteroseismologi termasuk dalam dataset ini; fitur diberi label dalam `y` dan disimpan di `X`.

```
df=pd.read_csv('/content/classification_in_asteroseismology.csv')
X = df.iloc[:, 1:].values
y = df.iloc[:, 0].values
```

Langkah 2: Menyiapkan Data

Saya menggunakan `train test split` dari scikit-learn untuk membagi data menjadi set pelatihan dan pengujian agar siap untuk pembelajaran mesin. Fitur kemudian dinormalisasi dengan menerapkan penskalaan fitur menggunakan `StandardScaler`, memastikan fitur memiliki rata-rata 0 dan deviasi standar 1. Mesin Pendukung (SVM) dan algoritma pembelajaran mesin lainnya beroperasi paling baik ketika langkah ini diikuti.

```
from sklearn.preprocessing import StandardScaler
sc = StandardScaler()
X_train = sc.fit_transform(X_train)
X_test = sc.transform(X_test)
```

Langkah 3: Melatih Model SVM

Pilihan saya adalah menggunakan kernel linear pada klasifikasi Mesin Pendukung (SVM). `classifier.fit(X_train, y_train)` digunakan untuk melatih model menggunakan data pelatihan yang telah dinormalisasi.

```
from sklearn.svm import SVC
classifier = SVC(kernel = 'linear', random_state = 0)
classifier.fit(X_train, y_train)
```

Langkah 4: Visualisasi Data Pelatihan

Saya menggunakan Matplotlib untuk membuat plot sebar 3D untuk memperoleh wawasan tentang distribusi data pelatihan dalam ruang fitur. Titik data diwarnai berdasarkan label terkait ('POP'), dan tiga sumbu ('Dnu', 'numax', dan 'epsilon') mencerminkan fitur saya.

![Alt text](https://github.com/robbytbg/Port2/blob/main/Machine%20Learning/3D_viz.PNG)

Langkah 5: Mengevaluasi Model

Saya menghasilkan prediksi pada set pengujian `(y_pred = classifier.predict(X_test))` dan menghitung skor akurasi `(accuracy_score(y_test, y_pred))` serta matriks kebingungan `(cm = confusion_matrix(y_test, y_pred))` untuk mengevaluasi kinerja model SVM saya. Metrik-metrik ini memberikan informasi yang berguna tentang seberapa baik model berkinerja dalam klasifikasi kelas.

```
from sklearn.metrics import confusion_matrix, accuracy_score

y_pred = classifier.predict(X_test)
cm = confusion_matrix(y_test, y_pred)
print(cm)
accuracy_score(y_test, y_pred)
```

Langkah 6: Meramalkan Informasi Baru

Terakhir, saya meramalkan kelas dari titik data baru `[[4.4478, 43.06289, 0.985]]` menggunakan model SVM yang telah dilatih. Ini mengilustrasikan bagaimana model saya dapat digunakan dalam praktik dengan data yang tidak diketahui.

```
print(classifier.predict(sc.transform([[4.4478,43.06289,0.985]])))
```
