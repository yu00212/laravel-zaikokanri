<x-app-layout>
@section('title', '在庫編集')
    <x-slot name="header">
        <h2 class="text-lg text-gray-800 leading-tight">
            {{ __('在庫編集') }}
        </h2>
    </x-slot>

    <div class="flex justify-center mt-12">
        <p class="py-2 px-4">
        下記の内容で間違い無いですか？</p>
    </div>

    <div class="flex justify-center mt-12">
        <form method="post" action="/list/editDone/{{$stock['id']}}" enctype="multipart/form-data"
                class="grid grid-cols-1 gap-6">
        @csrf
            <label class="block px-16">
                <span class="text-gray-700">店名</span>
                <input type="text" name="shop" value="{{$stock['shop']}}" readonly
                class="block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
            </label>

            <label class="block px-16">
                <span class="text-gray-700">購入日</span>
                <input type="date" name="purchase_date" value="{{$stock['purchase_date']}}" readonly
                class="block rounded-md border-gray-300 shadow-sm focus:border-purple-400 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
            </label>

            <label class="block px-16">
                <span class="text-gray-700">期限</span>
                <input type="date" name="deadline" value="{{$stock['deadline']}}" readonly
                class="block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
            </label>

            <label class="block px-16">
                <span class="text-gray-700">商品名</span>
                <input type="text" name="name" value="{{$stock['name']}}" readonly
                class="block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
            </label>

            <label class="block px-16">
                <span class="text-gray-700">値段</span>
                <input type="text" name="price" value="{{$stock['price']}}" readonly
                class="block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
            </label>

            <label class="bloc px-16">
                <span class="text-gray-700">数量</span>
                <input type="number" name="number" value="{{$stock['number']}}" readonly
                class="block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
            </label>

            <span class="text-gray-700">画像</span>
            @if ($stock['image'] !== "")
            <img src="{{ asset('storage/tmp/' . $stock['image']) }}">
            @endif

            <div class="flex justify-center py-6 xl:ml-40 xl:-mt-8">
                <button name="action" value="edit"
                    class="w-32 py-2 border-2 border-purple-500 bg-gradient-to-r from-purple-200 to-pink-200 font-semibold hover:opacity-75 rounded
                            md:mt-6">編集</button>
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

    <div class="xl:mt-1">
        <form method="post" action="/list/edit/{{$stock['id']}}" class="grid grid-cols-1 gap-6">
            @csrf
                <div class="flex justify-center py-6 xl:mr-40 xl:-mt-20">
                    <button name="action" value="back"
                        class="w-32 text-center py-2 px-4 border-2 border-purple-500 bg-gradient-to-r from-purple-200 to-pink-200 font-semibold hover:opacity-75 rounded
                                -mt-4 mb-10">戻る</button>
                    <input type="hidden" name="id" value="{{$stock['id']}}">
                    <input type="hidden" name="shop" value="{{$stock['shop']}}">
                    <input type="hidden" name="purchase_date" value="{{$stock['purchase_date']}}">
                    <input type="hidden" name="deadline" value="{{$stock['deadline']}}">
                    <input type="hidden" name="name" value="{{$stock['name']}}">
                    <input type="hidden" name="price" value="{{$stock['price']}}">
                    <input type="hidden" name="number" value="{{$stock['number']}}">
                    <input type="hidden" name="image" value="{{$stock['image']}}">
                </div>
            </form>
        </div>
</x-app-layout>
