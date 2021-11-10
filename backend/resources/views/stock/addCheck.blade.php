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
        <form action="/list/addDone" method="post" enctype="multipart/form-data" class="grid grid-cols-1 gap-6">
            @csrf
            @elsecan('guest') {{-- ゲストに表示される --}}
            <form action="/guest/list/addDone" method="post" enctype="multipart/form-data" class="grid grid-cols-1 gap-6">
                @csrf
                @endcan
                <div class="container flex justify-center">
                    <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3">
                        <div></div>
                        <div class="flex justify-center">
                            <label class="text-center w-44">
                                @if ($stock['image'] !== "")
                                <img src="{{ asset('storage/tmp/' . $stock['image']) }}" class="h-48 w-full">
                                @elseif ($stock['image'] == "")
                                <img src="https://zaikokanri.s3.ap-northeast-1.amazonaws.com/SQBzGcvgGvOftMYGWG85i2DBuXaONl6FbiW9uwoA.jpg" class="h-48 w-full">
                                @endif
                            </label>
                        </div>
                        <div></div>

                        <div class="mt-10 flex justify-center md:px-20 xl:px-20">
                            <label>
                                <span class="text-gray-700">店名</span>
                                <p class="w-44 block shadow-sm">{{$stock['shop']}}</p>
                            </label>
                        </div>

                        <div class="mt-10 flex justify-center md:px-20 xl:px-20">
                            <label>
                                <span class="text-gray-700">購入日</span>
                                <p class="w-44 block shadow-sm">{{$stock['purchase_date']}}</p>
                            </label>
                        </div>

                        <div class="mt-10 flex justify-center md:px-20 xl:px-20">
                            <label>
                                <span class="text-gray-700">期限</span>
                                <p class="w-44 block shadow-sm">{{$stock['deadline']}}</p>
                            </label>
                        </div>

                        <div class="mt-10 flex justify-center md:px-20 xl:px-20">
                            <label>
                                <span class="text-gray-700">商品名</span>
                                <p class="w-44 block shadow-sm">{{$stock['name']}}</p>
                            </label>
                        </div>

                        <div class="mt-10 flex justify-center md:px-20 xl:px-20">
                            <label>
                                <span class="text-gray-700">値段</span>
                                <p class="w-44 block shadow-sm">{{$stock['price']}}</p>
                            </label>
                        </div>

                        <div class="mt-10 flex justify-center md:px-20 xl:px-20">
                            <label>
                                <span class="text-gray-700">数量</span>
                                <p class="w-44 block shadow-sm">{{$stock['number']}}</p>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center ml-40 mt-8 mb-32">
                    <button class="h-11 w-24 mr-2 py-2 border-2 text-center border-purple-500 bg-gradient-to-r from-purple-200 to-pink-200 font-semibold hover:opacity-75 rounded
                        md:ml-20">確認</button>
                </div>
    </div>

    <input type="hidden" name="shop" value="{{$stock['shop']}}">
    <input type="hidden" name="purchase_date" value="{{$stock['purchase_date']}}">
    <input type="hidden" name="deadline" value="{{$stock['deadline']}}">
    <input type="hidden" name="name" value="{{$stock['name']}}">
    <input type="hidden" name="price" value="{{$stock['price']}}">
    <input type="hidden" name="number" value="{{$stock['number']}}">
    <input type="hidden" name="image" value="{{$stock['image']}}">
    </form>

    @can('user-higher') {{-- 一般権限以上に表示される --}}
    <form action="/list/add" method="post" enctype="multipart/form-data">
        @csrf
        <div class="flex justify-center mr-32 -mt-40">
            <button name="action" class="-mt-3 mb-32 h-11 w-24 mr-2 py-2 border-2 text-center border-purple-500 bg-gradient-to-r from-purple-200 to-pink-200 font-semibold hover:opacity-75 rounded
                md:mr-24 xl:mr-20">戻る</button>
        </div>

        <input type="hidden" name="shop" value="{{$stock['shop']}}">
        <input type="hidden" name="purchase_date" value="{{$stock['purchase_date']}}">
        <input type="hidden" name="deadline" value="{{$stock['deadline']}}">
        <input type="hidden" name="name" value="{{$stock['name']}}">
        <input type="hidden" name="price" value="{{$stock['price']}}">
        <input type="hidden" name="number" value="{{$stock['number']}}">
        <input type="hidden" name="image" value="{{$stock['image']}}">
    </form>
    @elsecan('guest') {{-- ゲストに表示される --}}
    <form action="/guest/list/add" method="post" enctype="multipart/form-data">
        @csrf
        <div class="flex justify-center mr-36 -mt-40">
            <button name="action" class="-mt-3 mb-32 h-11 w-24 mr-2 py-2 border-2 text-center border-purple-500 bg-gradient-to-r from-purple-200 to-pink-200 font-semibold hover:opacity-75 rounded
                md:mr-24 xl:mr-20">戻る</button>
        </div>

        <input type="hidden" name="shop" value="{{$stock['shop']}}">
        <input type="hidden" name="purchase_date" value="{{$stock['purchase_date']}}">
        <input type="hidden" name="deadline" value="{{$stock['deadline']}}">
        <input type="hidden" name="name" value="{{$stock['name']}}">
        <input type="hidden" name="price" value="{{$stock['price']}}">
        <input type="hidden" name="number" value="{{$stock['number']}}">
        <input type="hidden" name="image" value="{{$stock['image']}}">
    </form>
    @endcan

    </div>
</x-app-layout>
