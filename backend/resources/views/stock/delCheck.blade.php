<x-app-layout>
    @section('title', '在庫削除')
    <x-slot name="header">
        <h2 class="text-lg text-gray-800 leading-tight">
            {{ __('在庫削除') }}
        </h2>
    </x-slot>

    <div class="flex justify-center py-6 lg:py-24 xl:-mt-16 xl:-mb-20">
        <p class="py-2 px-4">下記の在庫を削除しますか？</p>
    </div>

    <div class="flex justify-center">
        @can('admin-higher') {{-- 管理者権限以上に表示される --}}
        <form method="post" action="/admin/list/delDone/{{$stock['id']}}" enctype="multipart/form-data" class="grid grid-cols-1 gap-6">
            @csrf
            @elsecan('user-higher') {{-- 一般権限以上に表示される --}}
            <form method="post" action="/list/delDone/{{$stock['id']}}" enctype="multipart/form-data" class="grid grid-cols-1 gap-6">
                @csrf
                @elsecan('guest') {{-- ゲストに表示される --}}
                <form method="post" action="/guest/list/delDone/{{$stock['id']}}" enctype="multipart/form-data" class="grid grid-cols-1 gap-6">
                    @csrf
                    @endcan
                    <div class="container flex justify-center">
                        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3">
                            <div></div>
                            <div class="flex justify-center">
                                <label class="w-48">
                                    <span class="text-gray-700">商品画像</span>
                                    @if ($stock['image'] !== "dummy.jpg")
                                    <img src="{{ asset('storage/images/' . $stock->image) }}" class="h-48 w-full" />
                                    @elseif ($stock['image'] == "dummy.jpg")
                                    <img src="{{ asset('storage/images/no-image.png') }}" class="h-48 w-full" />
                                    @endif
                                </label>
                            </div>
                            <div></div>

                            <div class="mt-10 flex justify-center">
                                <label class="">
                                    <span class="text-gray-700">店名</span>
                                    <p class="w-48 block rounded-md border-gray-100 shadow-sm">{{$stock['shop']}}</p>
                                    @error('shop')
                                    <p>❗️<span class="text-red-500">{{$message}}</span</p> @enderror </label> </div> <div class="mt-10 flex justify-center md:px-12 xl:px-20">
                                            <label class="">
                                                <span class="text-gray-700">購入日</span>
                                                <p class="w-48 block rounded-md border-gray-100 shadow-sm">{{$stock['purchase_date']}}</p>
                                                @error('purchase_date')
                                                <p>❗️<span class="text-red-500">{{$message}}</span</p> @enderror </label> </div> <div class="mt-10 flex justify-center">
                                                        <label class="">
                                                            <span class="text-gray-700">期限</span>
                                                            <p class="w-48 block rounded-md border-gray-100 shadow-sm">{{$stock['deadline']}}</p>
                                                            @error('deadline')
                                                            <p>❗️<span class="text-red-500">{{$message}}</span></p>
                                                            @enderror
                                                        </label>
                            </div>

                            <div class="mt-10 flex justify-center">
                                <label class="">
                                    <span class="text-gray-700">商品名</span>
                                    <p class="w-48 block rounded-md border-gray-100 shadow-sm">{{$stock['name']}}</p>
                                    @error('name')
                                    <p>❗️<span class="text-red-500">{{$message}}</span</p> @enderror </label> </div> <div class="mt-10 flex justify-center">
                                            <label class="">
                                                <span class="text-gray-700">値段</span>
                                                <p class="w-48 block rounded-md border-gray-100 shadow-sm">{{$stock['price']}}</p>
                                                @error('price')
                                                <p>❗️<span class="text-red-500">{{$message}}</span</p> @enderror </label> </div> <div class="mt-10 flex justify-center">
                                                        <label class="">
                                                            <span class="text-gray-700">数量</span>
                                                            <p class="w-48 block rounded-md border-gray-100 shadow-sm">{{$stock['number']}}</p>
                                                            @error('number')
                                                            <p class="-mt-14">❗️<span class="text-red-500">{{$message}}</span</p> @enderror </label> </div> </div> </div> <div class="flex justify-center mt-12 mb-20">
                                                                    @can('admin-higher')　{{-- 管理者権限以上に表示される --}}
                                                                    <a href="/admin/list" class="h-11 w-24 mr-2 py-2 border-2 text-center border-purple-500 bg-gradient-to-r from-purple-200 to-pink-200 font-semibold hover:opacity-75 rounded
                                md:mr-24 xl:mr-32">戻る</a>
                                                                    @elsecan('user-higher') {{-- 一般権限以上に表示される --}}
                                                                    <a href="/list" class="h-11 w-24 mr-2 py-2 border-2 text-center border-purple-500 bg-gradient-to-r from-purple-200 to-pink-200 font-semibold hover:opacity-75 rounded
                                md:mr-24 xl:mr-32">戻る</a>
                                                                    @elsecan('guest') {{-- ゲストに表示される --}}
                                                                    <a href="/guest/list" class="h-11 w-24 mr-2 py-2 border-2 text-center border-purple-500 bg-gradient-to-r from-purple-200 to-pink-200 font-semibold hover:opacity-75 rounded
                                md:mr-24 xl:mr-32">戻る</a>
                                                                    @endcan

                                                                    <button name="action" value="register" class="h-11 w-24 ml-2 py-2 border-2 text-center border-purple-500 bg-gradient-to-r from-purple-200 to-pink-200 font-semibold hover:opacity-75 rounded
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
