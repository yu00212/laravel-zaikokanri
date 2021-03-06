<x-app-layout>
    @section('title', '在庫編集')
    <x-slot name="header">
        <h2 class="text-lg text-gray-800 leading-tight">
            {{ __('在庫編集') }}
        </h2>
    </x-slot>

    <div class="flex justify-center py-6 lg:py-24 xl:-mt-16 xl:-mb-20">
        <p class="py-2 px-4">下記の内容で間違い無いですか？</p>
    </div>

    <div class="flex justify-center">
        @can('user-higher') {{-- 一般権限以上に表示される --}}
        <form method="post" action="/list/editDone/{{$stock['id']}}" enctype="multipart/form-data" class="grid grid-cols-1 gap-6">
            @csrf
            @elsecan('guest') {{-- ゲストに表示される --}}
            <form method="post" action="/guest/list/editDone/{{$stock['id']}}" enctype="multipart/form-data" class="grid grid-cols-1 gap-6">
                @csrf
                @endcan
                <div class="container flex justify-center">
                    <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3">
                        <div></div>
                        <div class="flex justify-center">
                            <label class="text-center w-44">
                                @if ($stock['image'] == "" && $returnImage->image == "dummy.jpg")
                                <img src="https://zaikokanri.s3.ap-northeast-1.amazonaws.com/SQBzGcvgGvOftMYGWG85i2DBuXaONl6FbiW9uwoA.jpg" class="h-48 w-full" />
                                @elseif($stock['image'] !== "" && $returnImage == "")
                                <img src="{{ asset('storage/tmp/' . $stock['image']) }}" class="h-48 w-full" />
                                @elseif($stock['image'] == "" && $returnImage !== "" && $returnImage->image !== "dummy.jpg")
                                <img src="{{ Storage::disk('s3')->url($returnImage->image) }}" class="h-48 w-full">
                                @endif
                            </label>
                        </div>
                        <div></div>

                        <div class="mt-10 flex justify-center">
                            <label>
                                <span class="text-gray-700">店名</span>
                                <p class="w-44 block shadow-sm">{{$stock['shop']}}</p>
                            </label>
                        </div>

                        <div class="mt-10 flex justify-center md:px-12 xl:px-20">
                            <label>
                                <span class="text-gray-700">購入日</span>
                                <p class="w-44 block shadow-sm">{{$stock['purchase_date']}}</p>
                            </label>
                        </div>

                        <div class="mt-10 flex justify-center">
                            <label>
                                <span class="text-gray-700">期限</span>
                                <p class="w-44 block shadow-sm">{{$stock['deadline']}}</p>
                            </label>
                        </div>

                        <div class="mt-10 flex justify-center">
                            <label>
                                <span class="text-gray-700">商品名</span>
                                <p class="w-44 block shadow-sm">{{$stock['name']}}</p>
                            </label>
                        </div>

                        <div class="mt-10 flex justify-center">
                            <label>
                                <span class="text-gray-700">値段</span>
                                <p class="w-44 block shadow-sm">{{$stock['price']}}</p>
                            </label>
                        </div>

                        <div class="mt-10 flex justify-center">
                            <label>
                                <span class="text-gray-700">数量</span>
                                <p class="w-44 block shadow-sm">{{$stock['number']}}</p>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center mt-8 mb-20">
                    @can('user-higher') {{-- 一般権限以上に表示される --}}
                    <a href="/list/edit/{{$stock['id']}}" class="h-11 w-24 mr-2 py-2 text-center bg-blue-600 text-white font-semibold hover:opacity-75 rounded
                            mr-8 md:mr-24 xl:mr-20">戻る</a>
                    @elsecan('guest') {{-- ゲストに表示される --}}
                    <a href="/guest/list/edit/{{$stock['id']}}" class="h-11 w-24 mr-2 py-2 text-center bg-blue-600 text-white font-semibold hover:opacity-75 rounded
                            mr-8 md:mr-24 xl:mr-20">戻る</a>
                    @endcan

                    <button class="h-11 w-24 mr-2 py-2 text-center bg-blue-600 text-white font-semibold hover:opacity-75 rounded
                        ml-8 md:ml-12">確認</button>
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
    </div>
</x-app-layout>
