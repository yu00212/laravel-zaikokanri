<x-app-layout>
@section('title', '在庫削除')
    <x-slot name="header">
        <h2 class="text-lg text-gray-800 leading-tight">
            {{ __('在庫削除') }}
        </h2>
    </x-slot>

    <div class="flex justify-center mt-12">
        <p class="py-2 px-4">下記の在庫を削除しますか？</p>
    </div>

    <div class="flex justify-center break-words ml-4 mt-12 xl:ml-20">
        @can('admin-higher') {{-- 管理者権限以上に表示される --}}
            <form method="post" action="/admin/list/delDone/{{$stock['id']}}" enctype="multipart/form-data"
                    class="grid grid-cols-1 gap-6 ml-12 xl:mr-12">
            @csrf
        @elsecan('user-higher') {{-- 一般権限以上に表示される --}}
            <form method="post" action="/list/delDone/{{$stock['id']}}" enctype="multipart/form-data"
                    class="grid grid-cols-1 gap-6 ml-12 xl:mr-12">
            @csrf
        @elsecan('guest') {{-- ゲストに表示される --}}
            <form method="post" action="/guest/list/delDone/{{$stock['id']}}" enctype="multipart/form-data"
                    class="grid grid-cols-1 gap-6 ml-12 xl:mr-12">
            @csrf
        @endcan
        <div class="container">
        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-1 xl:grid-cols-3">
            <div></div>
            <div class="mr-14">
                <span class="text-gray-700">商品画像</span>
                @if ($stock['image'] !== "dummy.jpg")
                    <img src="{{ asset('storage/images/' . $stock->image) }}" class="img-fluid"/>
                @elseif ($stock['image'] == "dummy.jpg")
                    <img src="{{ asset('storage/images/no-image.png') }}" class="img-fluid"/>
                @endif
            </div>
            <div></div>

            <div class="ml-10">
                <label class="block mt-12">
                    <span class="text-gray-700">店名</span>
                    <input type="text" name="shop" value="{{$stock['shop']}}" readonly
                    class="block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
                    @error('shop')
                    <p>❗️<span class="text-red-500">{{$message}}</span</p>
                    @enderror
                </label>
            </div>

            <div class="ml-10">
                <label class="block mt-12">
                    <span class="text-gray-700">購入日</span>
                    <input type="date" name="purchase_date" value="{{$stock['purchase_date']}}" readonly
                    class="block rounded-md border-gray-300 shadow-sm focus:border-purple-400 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
                    @error('purchase_date')
                    <p>❗️<span class="text-red-500">{{$message}}</span</p>
                    @enderror
                </label>
            </div>

            <div class="ml-10">
                <label class="block mt-12">
                    <span class="text-gray-700">期限</span>
                    <input type="date" name="deadline" value="{{$stock['deadline']}}" readonly
                    class="block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
                    @error('deadline')
                    <p>❗️<span class="text-red-500">{{$message}}</span></p>
                    @enderror
                </label>
            </div>

            <div class="ml-10">
                <label class="block mt-12">
                    <span class="text-gray-700">商品名</span>
                    <input type="text" name="name" value="{{$stock['name']}}" readonly
                    class="block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
                    @error('name')
                    <p>❗️<span class="text-red-500">{{$message}}</span</p>
                    @enderror
                </label>
            </div>

            <div class="ml-10">
                <label class="block mt-12">
                    <span class="text-gray-700">値段</span>
                    <input type="text" name="price" value="{{$stock['price']}}" readonly
                    class="block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
                    @error('price')
                    <p>❗️<span class="text-red-500">{{$message}}</span</p>
                    @enderror
                </label>
            </div>

            <div class="ml-10">
                <label class="block mt-12">
                    <span class="text-gray-700">数量</span>
                    <input type="number" name="number" value="{{$stock['number']}}" readonly
                    class="block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
                    @error('number')
                    <p class="-mt-14">❗️<span class="text-red-500">{{$message}}</span</p>
                    @enderror
                </label>
            </div>
        </div>

        <div class="flex justify-center mr-10 mt-12 mb-20
                    md:mt-24 xl:mt-20">
            @can('admin-higher')　{{-- 管理者権限以上に表示される --}}
            <a href="/admin/list"
                class="h-11 w-32 py-2 border-2 text-center border-purple-500 bg-gradient-to-r from-purple-200 to-pink-200 font-semibold hover:opacity-75 rounded
                        mr-6 xl:mr-32">一覧に戻る</a>
            @elsecan('user-higher') {{-- 一般権限以上に表示される --}}
                <a href="/list"
                    class="h-11 w-32 py-2 border-2 text-center border-purple-500 bg-gradient-to-r from-purple-200 to-pink-200 font-semibold hover:opacity-75 rounded
                            mr-6 xl:mr-32">一覧に戻る</a>
            @elsecan('guest') {{-- ゲストに表示される --}}
                <a href="/guest/list"
                    class="h-11 w-32 py-2 border-2 text-center border-purple-500 bg-gradient-to-r from-purple-200 to-pink-200 font-semibold hover:opacity-75 rounded
                            mr-6 xl:mr-32">一覧に戻る</a>
            @endcan

            <button name="action" value="register"
                class="h-11 w-32 py-2 border-2 text-center border-purple-500 bg-gradient-to-r from-purple-200 to-pink-200 font-semibold hover:opacity-75 rounded
                xl:-ml-12">削除</button>
        </div>

            <input type="hidden" name="shop" value="{{$stock['shop']}}">
            <input type="hidden" name="purchase_date" value="{{$stock['shop']}}">
            <input type="hidden" name="purchase_date" value="{{$stock['purchase_date']}}">
            <input type="hidden" name="deadline" value="{{$stock['deadline']}}">
            <input type="hidden" name="name" value="{{$stock['name']}}">
            <input type="hidden" name="price" value="{{$stock['price']}}">
            <input type="hidden" name="number" value="{{$stock['number']}}">
            <input type="hidden" name="image" value="{{$stock['image']}}">
        </form>
    </div>
</x-app-layout>

