<x-app-layout>
@section('title', '在庫詳細')
    <x-slot name="header">
        <h2 class="text-lg text-gray-800 leading-tight">
            {{ __('在庫詳細') }}
        </h2>
    </x-slot>

    <div class="flex justify-center break-words ml-10 mt-12
                md:ml-56 lg:ml-64 xl:mr-64 xl:ml-24">
        <div class="container lg:ml-40">
            <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-1 xl:grid-cols-3">
                <div></div>
                <div class="">
                    <span class="text-gray-700">商品画像</span>
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

            <div class="flex justify-center mr-20 mt-12 mb-24
                        md:-ml-48 lg:mr-40 xl:ml-32">
                @can('admin-higher')　{{-- 管理者権限以上に表示される --}}
                    <a href="/admin/list"
                        class="py-2 border-2 text-center border-purple-500 px-4 bg-gradient-to-r from-purple-200 to-pink-200
                                font-semibold hover:opacity-75 rounded md:w-32">一覧に戻る</a>
                @elsecan('user-higher') {{-- 一般権限以上に表示される --}}
                    <a href="/list"
                        class="py-2 border-2 text-center border-purple-500 px-4 bg-gradient-to-r from-purple-200 to-pink-200
                                font-semibold hover:opacity-75 rounded md:w-32">一覧に戻る</a>
                @elsecan('guest') {{-- ゲストに表示される --}}
                    <a href="/guest/list"
                        class="py-2 border-2 text-center border-purple-500 px-4 bg-gradient-to-r from-purple-200 to-pink-200
                                font-semibold hover:opacity-75 rounded md:w-32">一覧に戻る</a>
                @endcan
            </div>
        </div>
    </div>

</x-app-layout>
