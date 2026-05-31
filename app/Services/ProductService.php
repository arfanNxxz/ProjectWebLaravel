<?php

namespace App\Services;

use App\Models\Product;
use Exception;

class ProductService
{
    // 1. Fungsi Tambah Data
    public function storeProduct(array $data)
    {
        // Logika bisnis kita simpan di sini jika ada (misal: upload gambar, kalkulasi, dll)
        return Product::create($data);
    }

    // 2. Fungsi Tampilkan Data (Semua & Detail)
    public function getAllProducts()
    {
        return Product::all();
    }

    public function getProductById($id)
    {
        return Product::findOrFail($id);
    }

    // 3. Fungsi Ubah Data
    public function updateProduct($id, array $data)
    {
        $product = Product::findOrFail($id);
        $product->update($data);
        return $product;
    }

    // 4. Fungsi Hapus Data
    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        return $product->delete();
    }
}