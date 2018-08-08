# lib-form

Adalah module untuk verifikasi *user submitted data form*. Module ini 
menggunakan library `lib-validator` untuk validasi data.

## Instalasi

Jalankan perintah di bawah di folder aplikasi:

```
mim app install lib-form
```

## Konfigurasi

Semua konfiguasi form disimpan di konfigurasi masing-masing module dengan bentuk
seperti di bawah:

```php
return [
    // ...
    'libForm' => [
        'forms' => [
            '/form-name/' => [
                '/field-name/' => [
                    'label' => '/Field Label/',
                    'type'  => '/Field Type/',
                    'rules' => [
                        // list of rules
                    ],
                    'filters' => [
                        // list of filters
                    ],
                    'children' => [
                        // list of children if any
                    ]
                ]
            ]
        ]
    ]
    // ...
];
```

Konfigurasi ini menggunakan struktur yang sama persis dengan
[lib-valiator](https://github.com/getmim/lib-validator). Kecuali properti
`label`, `type` yang adalah bagian form field pada saat generasi html input elemnt.

## Penggunaan

Ada beberapa cara untuk menggunakan form:

### FormCollection

Cara pertama adalah dengan mengakses langsung class `LibForm\Library\FormCollection`:

```php
use LibForm\Library\FormCollection;

$valid = FormCollection::validate($form_name, $preset_object);
```

### Form

Cara kedua adalah membuat object form sendiri:

```php
use LibForm\Library\Form;

$form = new Form($form_name);
$valid = $form->validate($preset_object);
```

### Service Form

Cara ketiga adalah dengan menggunakan service:

```php
$valid = $this->form->$form_name->validate($preset_object);
```

### Service FormCollection

Cara keempat adalah dengan memanggil langsung fungsi FormCollection
dari service:

```php
$valid = $this->form->validate($form_name, $preset_object);
```