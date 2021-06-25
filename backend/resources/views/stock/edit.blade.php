<x-app-layout>
@section('title', '在庫編集')
    <x-slot name="header">
        <h2 class="text-lg text-gray-800 leading-tight">
            {{ __('在庫編集') }}
        </h2>
    </x-slot>

    <div class="flex justify-center mt-12 break-words">
        <form action="/list/editCheck/{{$stock->id}}" method="post" class="grid grid-cols-1 gap-6">
        @csrf
            <label class="block px-16">
                <span class="text-gray-700">店名</span>
                <input type="text" name="shop" value="{{$stock->shop}}"
                class="block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
                @error('shop')
                <p class="text-red-500 text-sm">{{$message}}</p>
                @enderror
            </label>

            <label class="block px-16">
                <span class="text-gray-700">購入日</span>
                <input type="date" name="purchase_date" value="{{$stock->purchase_date}}"
                class="block rounded-md border-gray-300 shadow-sm focus:border-purple-400 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
                @error('purchase_date')
                <p class="text-red-500 text-sm">{{$message}}</span</p>
                @enderror
            </label>

            <label class="block px-16">
                <span class="text-gray-700">期限</span>
                <input type="date" name="deadline" value="{{$stock->deadline}}"
                class=" block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
                @error('deadline')
                <p class="text-red-500 text-sm ">{{$message}}</p>
                @enderror
            </label>

            <label class="block px-16">
                <span class="text-gray-700">商品名</span>
                <input type="text" name="name" value="{{$stock->name}}"
                class="block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
                @error('name')
                <p class="text-red-500 text-sm">{{$message}}</p>
                @enderror
            </label>

            <label class="block px-16">
                <span class="text-gray-700">値段</span>
                <input type="text" name="price" value="{{$stock->price}}"
                class="block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
                @error('price')
                <p class="text-red-500 text-sm">{{$message}}</p>
                @enderror
            </label>

            <label class="block px-16">
                <span class="text-gray-700">数量</span>
                <input type="number" name="number" value="{{$stock->number}}"
                class="block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30"></input>
                @error('number')
                <p class="text-red-500 text-sm">{{$message}}</p>
                @enderror
            </label>

            <div class="flex justify-center py-6 xl:ml-40 xl:-mt-8">
                <button class="w-32 py-2 border-2 border-purple-500 bg-gradient-to-r from-purple-200 to-pink-200 font-semibold rounded
                                md:mt-6">編集</button>
            </div>
        </form>
    </div>

            <div class="flex justify-center py-3  xl:mr-40 xl:-mt-20">
                <a href="/list"
                    class="w-32 text-center py-2 px-4 border-2 border-purple-500 bg-gradient-to-r from-purple-200 to-pink-200 font-semibold hover:opacity-75 rounded mb-10">
                    一覧に戻る</a>
            </div>
</x-app-layout>
