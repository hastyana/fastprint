<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::all();
        return view('cms.admin.content.product.index', [
            'products' => $products
    ]);
    }

    public function create()
    {
        $categories = Category::all();
        $statuses = Status::all();

        return view('cms.admin.content.product.create', [
                'categories' => $categories,
                'statuses' => $statuses
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        $product = new Product;
        DB::transaction(function () use ($product, $request) {
            $product->name = $request->name;
            $product->price = $request->price;
            $product->category_id = $request->category_id;
            $product->status_id = $request->status_id;    

            $product->save();
        });
    
        return redirect()->route('admin.product.index')->with([
            'status' => 'success',
            'message' => 'Produk berhasil disimpan!'
        ]);
    }

    // Edit page
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $statuses = Status::all();

        return view('cms.admin.content.product.edit', [
            'product' => $product,
            'categories' => $categories,
            'statuses' => $statuses
        ]);
    }

    // Handling submit update event
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);
        DB::transaction(function () use ($product, $request) {
            $product->name = $request->name;
            $product->price = $request->price;
            $product->category_id = $request->category_id;
            $product->status_id = $request->status_id;  

            $product->save();
        });
    
        return redirect()->route('admin.product.index')->with([
            'status' => 'success',
            'message' => 'Produk berhasil diperbarui!'
        ]);
    }

    // Fungsi show untuk menampilkan detail event
    public function show($id)
    {
        $product = Product::findOrFail($id);

        return view('cms.admin.content.product.show', [
            'product' => $product
        ]);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        $product->delete();

        // Redirect ke halaman lain dengan pesan sukses
        return redirect()->route('admin.product.index')->with([
            'status' => 'success',
            'message' => 'Produk berhasil dihapus!'
        ]);
    }

    private function getApiCredentials()  
    {  
        // Get current date in Jakarta timezone  
        $date = now('Asia/Jakarta');  
        
        // Bulatkan jam ke atas jika menit lebih dari 0    
        $hour = $date->format('H');    
        if ($date->format('i') > 0) {    
            $hour = (int)$hour + 1; // Tambahkan 1 jam    
        }    
        
        // Pastikan jam tidak lebih dari 23    
        if ($hour > 23) {    
            $hour = 0; // Reset ke 0 jika lebih dari 23    
        }   
    
        $username = 'tesprogrammer' . $date->format('dmy') . 'C' . str_pad($hour, 2, '0', STR_PAD_LEFT);  
        
        // Create password with leading zero for month  
        $passwordString = 'bisacoding-' . $date->format('d-m-y');  
        $password = md5($passwordString);  
    
        return [  
            'username' => $username,  
            'password' => $password  
        ];  
    } 

    public function fetchProducts()  
    {  
        try {  
            $credentials = $this->getApiCredentials();  
              
            Log::info('Sending API request with:', [  
                'username' => $credentials['username'],  
                'password' => $credentials['password']  
            ]);  
              
            $response = Http::asForm()->post('https://recruitment.fastprint.co.id/tes/api_tes_programmer', [  
                'username' => $credentials['username'],  
                'password' => $credentials['password']  
            ]);  
      
            Log::info('API Response:', $response->json());  
      
            $responseData = $response->json();  
      
            if (isset($responseData['error']) && $responseData['error'] == 1) {  
                return back()->with('error', 'API Error: ' . ($responseData['ket'] ?? 'Unknown error'));  
            }  
      
            if ($response->successful() && isset($responseData['data'])) {  
                foreach ($responseData['data'] as $item) {  
                    $category = Category::firstOrCreate(['name' => $item['kategori']]);  
                    $status = Status::firstOrCreate(['name' => $item['status']]);  
                    
                    Product::updateOrCreate(  
                        [  
                            'id' => $item['id_produk']   
                        ],  
                        [  
                            'name' => $item['nama_produk'],  
                            'price' => $item['harga'],  
                            'category_id' => $category->id,  
                            'status_id' => $status->id  
                        ]  
                    );  
                }  
                return redirect()->route('index')->with('success', 'Products imported successfully');  
            }  
              
            return back()->with('error', 'Failed to fetch data: Invalid response format');  
        } catch (\Exception $e) {  
            Log::error('Error fetching products: ' . $e->getMessage());  
            return back()->with('error', 'Error: ' . $e->getMessage());  
        }     
    }

    public function debugApi()
    {
        $credentials = $this->getApiCredentials();
        
        return response()->json([
            'time' => now()->format('Y-m-d H:i:s'),
            'credentials' => $credentials,
            'password_before_md5' => 'bisacoding-' . now()->format('d-m-y')
        ]);
    }
}
