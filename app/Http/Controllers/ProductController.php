<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Exception;

class ProductController extends Controller
{
    protected $productService;

    // Inject ProductService ke dalam constructor
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    // Fungsi Tampilkan Data (Index)
    public function index()
    {
        try {
            $products = $this->productService->getAllProducts();
            return response()->json([
                'status' => 'success',
                'data' => $products
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data: ' . $e->getMessage()
            ], 500);
        }
    }

    // Fungsi Tambah Data (Store) dengan Validasi & Error Handling
    public function store(StoreProductRequest $request)
    {
        try {
            // Data otomatis tervalidasi oleh StoreProductRequest
            $validatedData = $request->validated();
            
            // Proses simpan dilempar ke Service
            $product = $this->productService->storeProduct($validatedData);

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil ditambahkan!',
                'data' => $product
            ], 201);

        } catch (Exception $e) {
            // Error handling jika terjadi kegagalan sistem/database
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menambahkan data: ' . $e->getMessage()
            ], 500);
        }
    }

    // Fungsi Ubah Data (Update)
    public function update(Request $request, $id)
    {
        try {
            // Validasi sederhana langsung di controller untuk update
            $validatedData = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'price' => 'sometimes|required|numeric|min:0',
                'stock' => 'sometimes|required|integer|min:0',
            ]);

            $product = $this->productService->updateProduct($id, $validatedData);

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil diubah!',
                'data' => $product
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengubah data atau data tidak ditemukan: ' . $e->getMessage()
            ], 404);
        }
    }

    // Fungsi Hapus Data (Destroy)
    public function destroy($id)
    {
        try {
            $this->productService->deleteProduct($id);
            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil dihapus!'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghapus data atau data tidak ditemukan: ' . $e->getMessage()
            ], 404);
        }
    }
}