<x-app-layout>
@section('title', '在庫詳細')
    <x-slot name="header">
        <h2 class="text-lg text-gray-800 leading-tight">
            {{ __('在庫詳細') }}
        </h2>
    </x-slot>

    <div class="flex justify-center">
        <div class="mt-12 grid grid-cols-1 gap-6">
            <label class="block">
                <span class="text-gray-700">店名</span>
                <input type="text" name="shop" value="{{$stock['shop']}}" readonly
                class="block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
                @error('shop')
                <p>❗️<span class="text-red-500">{{$message}}</span</p>
                @enderror
            </label>

            <label class="block">
                <span class="text-gray-700">購入日</span>
                <input type="date" name="purchase_date" value="{{$stock['purchase_date']}}" readonly
                class="block rounded-md border-gray-300 shadow-sm focus:border-purple-400 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
                @error('purchase_date')
                <p>❗️<span class="text-red-500">{{$message}}</span</p>
                @enderror
            </label>

            <label class="block">
                <span class="text-gray-700">期限</span>
                <input type="date" name="deadline" value="{{$stock['deadline']}}" readonly
                class="block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
                @error('deadline')
                <p>❗️<span class="text-red-500">{{$message}}</span></p>
                @enderror
            </label>

            <label class="block">
                <span class="text-gray-700">商品名</span>
                <input type="text" name="name" value="{{$stock['name']}}" readonly
                class="block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
                @error('name')
                <p>❗️<span class="text-red-500">{{$message}}</span</p>
                @enderror
            </label>

            <label class="block">
                <span class="text-gray-700">値段</span>
                <input type="text" name="price" value="{{$stock['price']}}" readonly
                class="block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
                @error('price')
                <p>❗️<span class="text-red-500">{{$message}}</span</p>
                @enderror
            </label>

            <label class="block">
                <span class="text-gray-700">数量</span>
                <input type="number" name="number" value="{{$stock['number']}}" readonly
                class="block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
                @error('number')
                <p class="-mt-14">❗️<span class="text-red-500">{{$message}}</span</p>
                @enderror
            </label>

            <div class="mt-6 mb-12 flex justify-center">
                    <a href="/system/list"
                        class="py-2 border-2 text-center border-purple-500 px-4 bg-gradient-to-r from-purple-200 to-pink-200 font-semibold hover:opacity-75 rounded
                                md:w-32">一覧に戻る</a>
                </div>
            </div>
        </div>

</x-app-layout>
