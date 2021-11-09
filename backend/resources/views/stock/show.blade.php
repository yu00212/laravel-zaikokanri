<x-app-layout>
    @section('title', '在庫詳細')
    <x-slot name="header">
        <h2 class="text-lg text-gray-800 leading-tight">
            {{ __('在庫詳細') }}
        </h2>
    </x-slot>

    <div class="flex justify-center mt-6 md:mt-24">
        <div class="container flex justify-center xl:-mt-12">
            <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3">
                <div></div>
                <div class="flex justify-center">
                    <label class="w-44">
                        @if ($stock['image'] !== "dummy.jpg")
                        <img src="{{ Storage::disk('s3')->url($stock->image) }}" class="h-48 w-full">
                        @elseif ($stock['image'] == "dummy.jpg")
                        <img src="{{ asset('storage/images/no-image.png') }}" class="h-48 w-full" />
                        @endif
                    </label>
                </div>
                <div></div>

                <div class="flex justify-center md:px-20 xl:px-20">
                    <label class="block mt-12">
                        <span class="text-gray-700">店名</span>
                        <p class="w-44 block shadow-sm">{{$stock['shop']}}</p>
                    </label>
                </div>

                <div class="flex justify-center md:px-20 xl:px-20">
                    <label class="block mt-12">
                        <span class="text-gray-700">購入日</span>
                        <p class="w-44 block shadow-sm">{{$stock['purchase_date']}}</p>
                    </label>
                </div>

                <div class="flex justify-center md:px-20 xl:px-20">
                    <label class="block mt-12">
                        <span class="text-gray-700">期限</span>
                        <p class="w-44 block shadow-sm">{{$stock['deadline']}}</p>
                    </label>
                </div>

                <div class="flex justify-center md:px-20 xl:px-20">
                    <label class="block mt-12">
                        <span class="text-gray-700">商品名</span>
                        <p class="w-44 block shadow-sm">{{$stock['name']}}</p>
                    </label>
                </div>

                <div class="flex justify-center md:px-20 xl:px-20">
                    <label class="block mt-12">
                        <span class="text-gray-700">値段</span>
                        <p class="w-44 block shadow-sm">{{$stock['price']}}</p>
                    </label>
                </div>

                <div class="flex justify-center md:px-20 xl:px-20">
                    <label class="block mt-12">
                        <span class="text-gray-700">数量</span>
                        <p class="w-44 block shadow-sm">{{$stock['number']}}</p>
                    </label>
                </div>

                <div></div>
                <div class="flex justify-center mt-12 mb-20 md:mt-24">
                    @can('admin-higher')　{{-- 管理者権限以上に表示される --}}
                    <a href="/admin/list" class="h-11 w-24 py-2 border-2 text-center border-purple-500 px-4 bg-gradient-to-r from-purple-200 to-pink-200
                        font-semibold hover:opacity-75 rounded
                        xl:-mt-10">戻る</a>
                    @elsecan('user-higher') {{-- 一般権限以上に表示される --}}
                    <a href="/list" class="h-11 w-24 py-2 border-2 text-center border-purple-500 px-4 bg-gradient-to-r from-purple-200 to-pink-200
                        font-semibold hover:opacity-75 rounded
                        xl:-mt-10">戻る</a>
                    @elsecan('guest') {{-- ゲストに表示される --}}
                    <a href="/guest/list" class="h-11 w-24 py-2 border-2 text-center border-purple-500 px-4 bg-gradient-to-r from-purple-200 to-pink-200
                        font-semibold hover:opacity-75 rounded
                        xl:-mt-10">戻る</a>
                    @endcan
                </div>
                <div></div>
            </div>

        </div>
    </div>

</x-app-layout>
