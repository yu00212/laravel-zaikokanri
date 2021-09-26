<x-app-layout>
    @section('title', '在庫編集')
    <x-slot name="header">
        <h2 class="text-lg text-gray-800 leading-tight">
            {{ __('在庫編集') }}
        </h2>
    </x-slot>

    <div class="flex justify-center mt-6 md:mt-12">
        @can('user-higher') {{-- 一般権限以上に表示される --}}
        <form action="/list/editCheck/{{$stock['id']}}" method="post" enctype="multipart/form-data" class="grid grid-cols-1 gap-6">
            @csrf
            @elsecan('guest') {{-- ゲストに表示される --}}
            <form action="/guest/list/editCheck/{{$stock['id']}}" method="post" enctype="multipart/form-data" class="grid grid-cols-1 gap-6">
                @csrf
                @endcan
                <div class="container flex justify-center xl:-mt-2">
                    <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3">
                        <div></div>
                        <div class="flex justify-center">
                            <label class="w-48 block">
                                <span class="text-gray-700">商品画像</span>
                                @if ($stock['image'] !== "dummy.jpg")
                                <img src="{{ asset('storage/images/' . $stock->image) }}" class="h-48 w-full" />
                                @elseif ($stock['image'] == "dummy.jpg")
                                <img src="{{ asset('storage/images/no-image.png') }}" class="h-48 w-full" />
                                @endif
                                <input id="image" type="file" name="image" class="-ml-10 mt-12 block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30"></input>
                                @error('image')
                                <p class="text-red-500 text-sm ">{{$message}}</p>
                                @enderror
                            </label>
                        </div>
                        <div></div>

                        <div class="flex justify-center">
                            <label class="block mt-12">
                                <span class="text-gray-700">店名</span>
                                <input type="text" name="shop" value="{{$stock['shop']}}" class="w-48 block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
                                @error('shop')
                                <p class="text-red-500 text-sm">{{$message}}</p>
                                @enderror
                            </label>
                        </div>

                        <div class="flex justify-center md:px-12 xl:px-20">
                            <label class="block mt-12">
                                <span class="text-gray-700">購入日</span>
                                <input type="date" name="purchase_date" value="{{$stock['purchase_date']}}" class="w-48 block rounded-md border-gray-300 shadow-sm focus:border-purple-400 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
                                @error('purchase_date')
                                <p class="text-red-500 text-sm ">{{$message}}</p>
                                @enderror
                            </label>
                        </div>

                        <div class="flex justify-center">
                            <label class="block mt-12">
                                <span class="text-gray-700">期限</span>
                                <input type="date" name="deadline" value="{{$stock['deadline']}}" class="w-48 block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
                                @error('deadline')
                                <p class="text-red-500 text-sm ">{{$message}}</p>
                                @enderror
                            </label>
                        </div>

                        <div class="flex justify-center">
                            <label class="block mt-12">
                                <span class="text-gray-700">商品名</span>
                                <input type="text" name="name" value="{{$stock['name']}}" class="w-48 block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
                                @error('name')
                                <p class="text-red-500 text-sm ">{{$message}}</p>
                                @enderror
                            </label>
                        </div>

                        <div class="flex justify-center">
                            <label class="block mt-12">
                                <span class="text-gray-700">値段</span>
                                <input type="text" name="price" value="{{$stock['price']}}" class="w-48 block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30"></input>
                                @error('price')
                                <p class="text-red-500 text-sm ">{{$message}}</p>
                                @enderror
                            </label>
                        </div>

                        <div class="flex justify-center">
                            <label class="block mt-12">
                                <span class="text-gray-700">数量</span>
                                <input type="number" name="number" value="{{$stock['number']}}" class="w-48 block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30"></input>
                                @error('number')
                                <p class="text-red-500 text-sm ">{{$message}}</p>
                                @enderror
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center mt-8 mb-20">
                    @can('user-higher') {{-- 一般権限以上に表示される --}}
                    <a href="/list" class="h-11 w-24 mr-2 py-2 border-2 text-center border-purple-500 bg-gradient-to-r from-purple-200 to-pink-200 font-semibold hover:opacity-75 rounded
                            md:mr-24 xl:mr-32">戻る</a>
                    @elsecan('guest') {{-- ゲストに表示される --}}
                    <a href="/guest/list" class="h-11 w-24 mr-2 py-2 border-2 text-center border-purple-500 bg-gradient-to-r from-purple-200 to-pink-200 font-semibold hover:opacity-75 rounded
                            md:mr-24 xl:mr-32">戻る</a>
                    @endcan

                    <button class="h-11 w-24 mr-2 py-2 border-2 text-center border-purple-500 bg-gradient-to-r from-purple-200 to-pink-200 font-semibold hover:opacity-75 rounded
                            xl:-ml-12">編集</button>
                </div>
            </form>
    </div>
</x-app-layout>
