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

                <div class="flex justify-center md:px-20 xl:px-20">
                    <label class="block px-12 py-2 rounded-md bg-gray-300">
                        <p class="text-center">画像を選択</p>
                        <input id="image" type="file" name="image" value="{{old('image')}}" class="hidden -ml-12 block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30"></input>
                        @error('image')
                        <p class="w-44 text-red-500 text-sm">{{$message}}</p>
                        @enderror
                    </label>
                </div>

                <div class="container flex justify-center xl:-mt-2">
                    <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3">
                        <div></div>
                        <div class="flex justify-center">
                            <label class="block w-44">
                                @if ($stock['image'] !== "dummy.jpg")
                                <img src="{{ Storage::disk('s3')->url($stock->image) }}" class="h-48 w-full">
                                @elseif ($stock['image'] == "dummy.jpg")
                                <img src="https://zaikokanri.s3.ap-northeast-1.amazonaws.com/SQBzGcvgGvOftMYGWG85i2DBuXaONl6FbiW9uwoA.jpg" class="h-48 w-full">
                                @endif
                                @error('image')
                                <p class="w-44 text-red-500 text-sm ">{{$message}}</p>
                                @enderror
                            </label>
                        </div>
                        <div></div>

                        <div class="flex justify-center md:px-20 xl:px-20">
                            <label class="block mt-12">
                                <span class="text-gray-700">店名</span>
                                <input type="text" name="shop" value="{{$stock['shop']}}" class="w-44 block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
                                @error('shop')
                                <p class="w-44 text-red-500 text-sm">{{$message}}</p>
                                @enderror
                            </label>
                        </div>

                        <div class="flex justify-center md:px-20 xl:px-20">
                            <label class="block mt-12">
                                <span class="text-gray-700">購入日</span>
                                <input type="date" name="purchase_date" value="{{$stock['purchase_date']}}" class="w-44 block rounded-md border-gray-300 shadow-sm focus:border-purple-400 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
                                @error('purchase_date')
                                <p class="w-44 text-red-500 text-sm ">{{$message}}</p>
                                @enderror
                            </label>
                        </div>

                        <div class="flex justify-center md:px-20 xl:px-20">
                            <label class="block mt-12">
                                <span class="text-gray-700">期限</span>
                                <input type="date" name="deadline" value="{{$stock['deadline']}}" class="w-44 block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
                                @error('deadline')
                                <p class="w-44 text-red-500 text-sm ">{{$message}}</p>
                                @enderror
                            </label>
                        </div>

                        <div class="flex justify-center md:px-20 xl:px-20">
                            <label class="block mt-12">
                                <span class="text-gray-700">商品名</span>
                                <input type="text" name="name" value="{{$stock['name']}}" class="w-44 block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
                                @error('name')
                                <p class="w-44 text-red-500 text-sm ">{{$message}}</p>
                                @enderror
                            </label>
                        </div>

                        <div class="flex justify-center md:px-20 xl:px-20">
                            <label class="block mt-12">
                                <span class="text-gray-700">値段</span>
                                <input type="text" name="price" value="{{$stock['price']}}" class="w-44 block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30"></input>
                                @error('price')
                                <p class="w-44 text-red-500 text-sm ">{{$message}}</p>
                                @enderror
                            </label>
                        </div>

                        <div class="flex justify-center md:px-20 xl:px-20">
                            <label class="block mt-12">
                                <span class="text-gray-700">数量</span>
                                <input type="number" name="number" value="{{$stock['number']}}" class="w-44 block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30"></input>
                                @error('number')
                                <p class="w-44 text-red-500 text-sm ">{{$message}}</p>
                                @enderror
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center mt-8 mb-20">
                    @can('user-higher') {{-- 一般権限以上に表示される --}}
                    <a href="/list" class="h-11 w-24 mr-2 py-2 border-2 text-center border-purple-500 bg-gradient-to-r from-purple-200 to-pink-200 font-semibold hover:opacity-75 rounded
                        mr-8 md:mr-20 xl:mr-32">戻る</a>
                    @elsecan('guest') {{-- ゲストに表示される --}}
                    <a href="/guest/list" class="h-11 w-24 mr-2 py-2 border-2 text-center border-purple-500 bg-gradient-to-r from-purple-200 to-pink-200 font-semibold hover:opacity-75 rounded
                        ml-2 mr-4 md:mr-20 xl:mr-32">戻る</a>
                    @endcan

                    <button class="h-11 w-24 mr-2 py-2 border-2 text-center border-purple-500 bg-gradient-to-r from-purple-200 to-pink-200 font-semibold hover:opacity-75 rounded
                        ml-12 xl:-ml-2">編集</button>
                </div>
            </form>
    </div>
</x-app-layout>
