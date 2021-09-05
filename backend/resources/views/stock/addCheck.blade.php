<x-app-layout>
@section('title', '在庫登録')
    <x-slot name="header">
        <h2 class="text-lg text-gray-800 leading-tight">
            {{ __('在庫登録') }}
        </h2>
    </x-slot>

    <div class="flex justify-center mt-12">
        <p class="py-2 px-4">
        下記の内容で間違い無いですか？</p>
    </div>

    <div class="flex justify-center break-words ml-4 mt-12">
        <form action="/list/addDone" method="post" enctype="multipart/form-data"
                class="grid grid-cols-1 gap-6 ml-12 xl:mr-12">
        @csrf
        <div class="container">
            <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-1 xl:grid-cols-3">
            <div></div>
            <div class="">
                <span class="text-gray-700">商品画像</span>
                    @if ($stock['image'] !== "")
                        <img src="{{ asset('storage/tmp/' . $stock['image']) }}" class="img-responsive">
                    @elseif ($stock['image'] == "")
                        <img src="{{ asset('storage/images/no-image.png') }}" class="img-responsive"/>
                    @endif
            </div>
            <div></div>

                <div class="ml-10">
                    <label class="block mt-12">
                        <span class="text-gray-700">店名</span>
                        <input type="text" name="shop" value="{{$stock['shop']}}" readonly
                        class="block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
                        @error('shop')
                        <p class="text-red-500 text-sm">{{$message}}</p>
                        @enderror
                    </label>
                </div>

                <div class="ml-10">
                    <label class="block mt-12">
                        <span class="text-gray-700">購入日</span>
                        <input type="date" name="purchase_date" value="{{$stock['purchase_date']}}" readonly
                        class=" block rounded-md border-gray-300 shadow-sm focus:border-purple-400 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
                        @error('purchase_date')
                        <p class="text-red-500 text-sm ">{{$message}}</p>
                        @enderror
                    </label>
                </div>

                <div class="ml-10">
                    <label class="block mt-12">
                        <span class="text-gray-700">期限</span>
                        <input type="date" name="deadline" value="{{$stock['deadline']}}" readonly
                        class=" block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
                        @error('deadline')
                        <p class="text-red-500 text-sm ">{{$message}}</p>
                        @enderror
                    </label>
                </div>

                <div class="ml-10">
                    <label class="block mt-12">
                        <span class="text-gray-700">商品名</span>
                        <input type="text" name="name" value="{{$stock['name']}}" readonly
                        class=" block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
                        @error('name')
                        <p class="text-red-500 text-sm ">{{$message}}</p>
                        @enderror
                    </label>
                </div>

                <div class="ml-10">
                    <label class="block mt-12">
                        <span class="text-gray-700">値段</span>
                        <input type="text" name="price" value="{{$stock['price']}}" readonly
                        class=" block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30"></input>
                        @error('price')
                        <p class="text-red-500 text-sm ">{{$message}}</p>
                        @enderror
                    </label>
                </div>

                <div class="ml-10">
                    <label class="block mt-12">
                        <span class="text-gray-700">数量</span>
                        <input type="number" name="number" value="{{$stock['number']}}" readonly
                        class=" block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30"></input>
                        @error('number')
                        <p class="text-red-500 text-sm ">{{$message}}</p>
                        @enderror
                    </label>
                </div>

            </div>

            <div class="flex justify-center mr-10 mt-12 mb-20 xl:ml-20 xl:mt-20">
            <button name="action" value="back"
                class="h-11 w-32 py-2 border-2 text-center border-purple-500 bg-gradient-to-r from-purple-200 to-pink-200 font-semibold hover:opacity-75 rounded
                        mr-6 xl:mr-32">戻る</button>

                <button name="action" value="register"
                        class="h-11 w-32 py-2 border-2 text-center border-purple-500 bg-gradient-to-r from-purple-200 to-pink-200 font-semibold hover:opacity-75 rounded
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

