
<x-app-layout>
@section('title', '在庫編集')
    <x-slot name="header">
        <h2 class="text-lg text-gray-800 leading-tight">
            {{ __('在庫編集') }}
        </h2>
    </x-slot>

    <div class="flex justify-center break-words ml-4 mt-12">
        <form action="/list/editCheck/{{$stock['id']}}" method="post" enctype="multipart/form-data"
                class="grid grid-cols-1 gap-6 ml-12 xl:mr-12">
        @csrf
        <div class="container">
            <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-1 xl:grid-cols-3">
                <div></div>
                <div class="-ml-6">
                    <label class="">
                        <span class="text-gray-700">商品画像</span>
                        <input id="image" type="file" name="image"
                        class="mb-6 block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30"></input>
                        @error('image')
                        <p class="text-red-500 text-sm ">{{$message}}</p>
                        @enderror
                    </label>

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
                        <input type="text" name="shop" value="{{$stock['shop']}}"
                        class="block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
                        @error('shop')
                        <p class="text-red-500 text-sm">{{$message}}</p>
                        @enderror
                    </label>
                </div>

                <div class="ml-10">
                    <label class="block mt-12">
                        <span class="text-gray-700">購入日</span>
                        <input type="date" name="purchase_date" value="{{$stock['purchase_date']}}"
                        class=" block rounded-md border-gray-300 shadow-sm focus:border-purple-400 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
                        @error('purchase_date')
                        <p class="text-red-500 text-sm ">{{$message}}</p>
                        @enderror
                    </label>
                </div>

                <div class="ml-10">
                    <label class="block mt-12">
                        <span class="text-gray-700">期限</span>
                        <input type="date" name="deadline" value="{{$stock['deadline']}}"
                        class=" block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
                        @error('deadline')
                        <p class="text-red-500 text-sm ">{{$message}}</p>
                        @enderror
                    </label>
                </div>

                <div class="ml-10">
                    <label class="block mt-12">
                        <span class="text-gray-700">商品名</span>
                        <input type="text" name="name" value="{{$stock['name']}}"
                        class=" block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
                        @error('name')
                        <p class="text-red-500 text-sm ">{{$message}}</p>
                        @enderror
                    </label>
                </div>

                <div class="ml-10">
                    <label class="block mt-12">
                        <span class="text-gray-700">値段</span>
                        <input type="text" name="price" value="{{$stock['price']}}"
                        class=" block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30"></input>
                        @error('price')
                        <p class="text-red-500 text-sm ">{{$message}}</p>
                        @enderror
                    </label>
                </div>

                <div class="ml-10">
                    <label class="block mt-12">
                        <span class="text-gray-700">数量</span>
                        <input type="number" name="number" value="{{$stock['number']}}"
                        class=" block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30"></input>
                        @error('number')
                        <p class="text-red-500 text-sm ">{{$message}}</p>
                        @enderror
                    </label>
                </div>

            </div>

            <div class="flex justify-center mr-10 mt-12 mb-20 xl:ml-6 xl:mt-20">
            <a href="/list"
                    class="h-11 w-32 py-2 border-2 text-center border-purple-500 bg-gradient-to-r from-purple-200 to-pink-200 font-semibold hover:opacity-75 rounded
                            mr-6 xl:mr-32">
                    一覧に戻る</a>

            <button class="h-11 w-32 py-2 border-2 text-center border-purple-500 bg-gradient-to-r from-purple-200 to-pink-200 font-semibold hover:opacity-75 rounded
                            xl:-ml-12">編集</button>

            </div>
        </form>
    </div>
</x-app-layout>
