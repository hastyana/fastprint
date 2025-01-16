@extends('cms.admin.layouts.mainLayout')

@section('plugin_css')
@endsection

@section('add_css')
@endsection

@section('content')

    <div class="flex flex-row justify-between items-center">
        <h3 class="text-gray-700 text-3xl font-medium">Products</h3>
        <a class="inline-flex items-center justify-center rounded-full text-base text-white bg-green-600 hover:bg-green-800 hover:text-gray-200 duration-300 py-2 px-4"
        href="{{ route('admin.product.create') }}" 
        >
            <i class="fi fi-br-add mr-2"></i> Add Product
        </a>
    </div>

    <div class="flex flex-col mt-8">
        <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
            <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50"></th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">

                        @forelse ($products as $product)

                        <tr>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                {{ $product->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                Rp. {{ number_format($product->price, 0, ',', '.') }}
                            </td>
                            <td class="capitalize px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                {{ $product->category->name }}
                            </td>
                            <td class="capitalize px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                {{ $product->status->name }}
                            </td>
                            <td class="px-6 py-4 space-x-2 space-y-2 whitespace-no-wrap text-right border-b border-gray-200 text-sm leading-5 font-medium">
                                <a href="{{ route('admin.product.show', $product->id) }}" class="text-green-600 hover:text-green-900 text-lg duration-300"><i class="fi fi-br-eye"></i></a>
                                <a href="{{ route('admin.product.edit', $product->id) }}" class="text-indigo-600 hover:text-indigo-900 text-lg duration-300"><i class="fi fi-br-file-edit"></i></a>
                                <form action="{{ route('admin.product.destroy', $product->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 text-lg duration-300"><i class="fi fi-br-cross-circle"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">No events found.</td>
                        </tr>

                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('plugin_js')
@endsection

@section('add_js')
@endsection