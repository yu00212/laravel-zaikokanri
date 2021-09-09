<x-app-layout>
@section('title', '在庫登録')
    <x-slot name="header">
        <h2 class="text-lg text-gray-800 leading-tight">
            {{ __('在庫登録') }}
        </h2>
    </x-slot>

    <div class="flex justify-center py-6 lg:py-24 xl:-mt-16 xl:-mb-20">
        <p class="py-2 px-4">下記の内容で間違い無いですか？</p>
    </div>

    <div class="flex justify-center">
        @can('user-higher') {{-- 一般権限以上に表示される --}}
            <form action="/list/addDone" method="post" enctype="multipart/form-data"
                    class="grid grid-cols-1 gap-6">
            @csrf
        @elsecan('guest') {{-- ゲストに表示される --}}
            <form action="/guest/list/addDone" method="post" enctype="multipart/form-data"
                    class="grid grid-cols-1 gap-6">
            @csrf
        @endcan
        <div class="container flex justify-center">
            <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3">
                <div></div>
                <div class="flex justify-center">
                    <label class="w-48">
                        <span class="text-gray-700">商品画像</span>
                            @if ($stock['image'] !== "")
                                <img src="{{ asset('storage/tmp/' . $stock['image']) }}" class="h-48 w-full">
                            @elseif ($stock['image'] == "")
                                <img src="{{ asset('storage/images/no-image.png') }}" class="h-48 w-full"/>
                            @endif
                    </label>
                </div>
                <div></div>

                <div class="mt-10 flex justify-center">
                    <label class="">
                        <span class="text-gray-700">店名</span>
                        <input type="text" name="shop" value="{{$stock['shop']}}" readonly
                        class="w-48 block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
                        @error('shop')
                        <p class="text-red-500 text-sm">{{$message}}</p>
                        @enderror
                    </label>
                </div>

                <div class="mt-10 flex justify-center md:px-12 xl:px-20">
                    <label class="">
                        <span class="text-gray-700">購入日</span>
                        <input type="date" name="purchase_date" value="{{$stock['purchase_date']}}" readonly
                        class="w-48 block rounded-md border-gray-300 shadow-sm focus:border-purple-400 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
                        @error('purchase_date')
                        <p class="text-red-500 text-sm ">{{$message}}</p>
                        @enderror
                    </label>
                </div>

                <div class="mt-10 flex justify-center">
                    <label class="">
                        <span class="text-gray-700">期限</span>
                        <input type="date" name="deadline" value="{{$stock['deadline']}}" readonly
                        class="w-48 block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
                        @error('deadline')
                        <p class="text-red-500 text-sm ">{{$message}}</p>
                        @enderror
                    </label>
                </div>

                <div class="mt-10 flex justify-center">
                    <label class="">
                        <span class="text-gray-700">商品名</span>
                        <input type="text" name="name" value="{{$stock['name']}}" readonly
                        class="w-48 block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
                        @error('name')
                        <p class="text-red-500 text-sm ">{{$message}}</p>
                        @enderror
                    </label>
                </div>

                <div class="mt-10 flex justify-center">
                    <label class="">
                        <span class="text-gray-700">値段</span>
                        <input type="text" name="price" value="{{$stock['price']}}" readonly
                        class="w-48 block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30"></input>
                        @error('price')
                        <p class="text-red-500 text-sm ">{{$message}}</p>
                        @enderror
                    </label>
                </div>

                <div class="mt-10 flex justify-center">
                    <label class="">
                        <span class="text-gray-700">数量</span>
                        <input type="number" name="number" value="{{$stock['number']}}" readonly
                        class="w-48 block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30"></input>
                        @error('number')
                        <p class="text-red-500 text-sm ">{{$message}}</p>
                        @enderror
                    </label>
                </div>
            </div>
        </div>

            <div class="flex justify-center mt-12 mb-20">
                <button name="action" value="back"
                    class="h-11 w-24 mr-2 py-2 border-2 text-center border-purple-500 bg-gradient-to-r from-purple-200 to-pink-200 font-semibold hover:opacity-75 rounded
                            md:mr-24 xl:mr-32">戻る</button>

                    <button name="action" value="register"
                            class="h-11 w-24 mr-2 py-2 border-2 text-center border-purple-500 bg-gradient-to-r from-purple-200 to-pink-200 font-semibold hover:opacity-75 rounded
                            xl:-ml-12">登録</button>
            </div>

            <input type="hidden" name="shop" value="{{$stock['shop']}}">
            <input type="hidden" name="purchase_date" value="{{$stock['purchase_date']}}">
            <input type="hidden" name="deadline" value="{{$stock['deadline']}}">
            <input type="hidden" name="name" value="{{$stock['name']}}">
            <input type="hidden" name="price" value="{{$stock['price']}}">
            <input type="hidden" name="number" value="{{$stock['number']}}">
            <input type="hidden" name="image" value="{{$stock['image']}}">
        </form>
    </div>
</x-app-layout>

