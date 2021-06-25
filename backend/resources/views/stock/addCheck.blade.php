<x-app-layout>
@section('title', '在庫登録')
    <x-slot name="header">
        <h2 class="text-lg text-gray-800 leading-tight">
            {{ __('在庫登録') }}
        </h2>
    </x-slot>

    @if (count($errors) > 0)
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="flex justify-center mt-12">
        <p class="py-2 px-4">
        下記の内容で間違い無いですか？</p>
    </div>

    @if (count($errors) > 0)
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="flex justify-center mt-12">
        <form method="post" action="/list/addDone" class="grid grid-cols-1 gap-6">
        @csrf
            <label class="block px-16">
                <span class="text-gray-700">店名</span>
                <input type="text" name="shop" value="{{$stock['shop']}}" readonly
                class="block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
                @error('shop')
                <p>❗️<span class="text-red-500">{{$message}}</span</p>
                @enderror
            </label>

            <label class="block px-16">
                <span class="text-gray-700">購入日</span>
                <input type="date" name="purchase_date" value="{{$stock['purchase_date']}}" readonly
                class="block rounded-md border-gray-300 shadow-sm focus:border-purple-400 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
                @error('purchase_date')
                <p>❗️<span class="text-red-500">{{$message}}</span</p>
                @enderror
            </label>

            <label class="block px-16">
                <span class="text-gray-700">期限</span>
                <input type="date" name="deadline" value="{{$stock['deadline']}}" readonly
                class="block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
                @error('deadline')
                <p>❗️<span class="text-red-500">{{$message}}</span></p>
                @enderror
            </label>

            <label class="block px-16">
                <span class="text-gray-700">商品名</span>
                <input type="text" name="name" value="{{$stock['name']}}" readonly
                class="block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
                @error('name')
                <p>❗️<span class="text-red-500">{{$message}}</span</p>
                @enderror
            </label>

            <label class="block px-16">
                <span class="text-gray-700">値段</span>
                <input type="text" name="price" value="{{$stock['price']}}" readonly
                class="block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
                @error('price')
                <p>❗️<span class="text-red-500">{{$message}}</span</p>
                @enderror
            </label>

            <label class="block px-16">
                <span class="text-gray-700">数量</span>
                <input type="number" name="number" value="{{$stock['number']}}" readonly
                class="block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
                @error('number')
                <p class="-mt-14">❗️<span class="text-red-500">{{$message}}</span</p>
                @enderror
            </label>

            <div class="flex justify-center py-6 xl:ml-40 xl:-mt-8">
                <button name="action" value="register"
                        class="w-32 py-2 border-2 border-purple-500 bg-gradient-to-r from-purple-200 to-pink-200 font-semibold rounded
                                md:mt-6">登録</button>
            </div>

            <div class="flex justify-center py-3 xl:mr-40 xl:-mt-20">
                <button name="action" value="back"
                    class="w-32 text-center py-2 px-4 border-2 border-purple-500 bg-gradient-to-r from-purple-200 to-pink-200 font-semibold hover:opacity-75 rounded
                            mb-10 -mt-6 xl:-mt-6">戻る</button>
            </div>

            <input type="hidden" name="shop" value="{{$stock['shop']}}">
            <input type="hidden" name="purchase_date" value="{{$stock['purchase_date']}}">
            <input type="hidden" name="deadline" value="{{$stock['deadline']}}">
            <input type="hidden" name="name" value="{{$stock['name']}}">
            <input type="hidden" name="price" value="{{$stock['price']}}">
            <input type="hidden" name="number" value="{{$stock['number']}}">
        </form>
    </div>
</x-app-layout>

