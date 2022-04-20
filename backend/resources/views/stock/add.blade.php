<x-app-layout>
    @section('title', '在庫登録')
    <x-slot name="header">
        <h2 class="text-lg text-gray-800 leading-tight">
            {{ __('在庫登録') }}
        </h2>
    </x-slot>

    <div class="flex justify-center mt-6 md:mt-24">
        @can('user-higher') {{-- 一般権限以上に表示される --}}
        <form action="/list/addCheck" method="post" enctype="multipart/form-data" class="grid grid-cols-1 gap-6">
            @csrf
            @elsecan('guest') {{-- ゲストに表示される --}}
            <form action="/guest/list/addCheck" method="post" enctype="multipart/form-data" class="grid grid-cols-1 gap-6">
                @csrf
                @endcan

                <div class="flex justify-center md:px-20 xl:px-20">
                    <label class="block px-12 py-2 rounded-md bg-gray-300">
                        <p class="text-center">画像を選択</p>
                        <input id="img_upload" type="file" accept="image/*" name="image" value="{{old('image')}}" class="hidden -ml-12" onchange=" previewImage(this)">
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
                                <img id="preview" class="h-48 w-full" src="https://zaikokanri.s3.ap-northeast-1.amazonaws.com/SQBzGcvgGvOftMYGWG85i2DBuXaONl6FbiW9uwoA.jpg">
                            </label>
                            <script>
                                function previewImage(obj) {
                                    var fileReader = new FileReader();
                                    fileReader.onload = (function() {
                                        document.getElementById('preview').src = fileReader.result;
                                    });
                                    fileReader.readAsDataURL(obj.files[0]);
                                }

                                $(function() {
                                    $(document).on('change', '#receipt', function() {
                                        $('#preview').addClass('img-thumbnail');
                                    });
                                });
                            </script>
                        </div>
                        <div></div>

                        <div class="flex justify-center md:px-20 xl:px-20">
                            <label class="block mt-12">
                                <span class="text-gray-700">店名</span>
                                <input type="text" name="shop" value="{{old('shop')}}" class="w-44 block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
                                @error('shop')
                                <p class="w-44 text-red-500 text-sm">{{$message}}</p>
                                @enderror
                            </label>
                        </div>

                        <div class="flex justify-center md:px-20 xl:px-20">
                            <label class="block mt-12">
                                <span class="text-gray-700">購入日</span>
                                <input type="date" name="purchase_date" value="{{old('purchase_date')}}" class="w-44 block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
                                @error('purchase_date')
                                <p class="w-44 text-red-500 text-sm">{{$message}}</p>
                                @enderror
                            </label>
                        </div>

                        <div class="flex justify-center md:px-20 xl:px-20">
                            <label class="block mt-12">
                                <span class="text-gray-700">期限</span>
                                <input type="date" name="deadline" value="{{old('deadline')}}" class="w-44 block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
                                @error('deadline')
                                <p class="w-44 text-red-500 text-sm">{{$message}}</p>
                                @enderror
                            </label>
                        </div>

                        <div class="flex justify-center md:px-20 xl:px-20">
                            <label class="block mt-12">
                                <span class="text-gray-700">商品名</span>
                                <input type="text" name="name" value="{{old('name')}}" class="w-44 block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30">
                                @error('name')
                                <p class="w-44 text-red-500 text-sm">{{$message}}</p>
                                @enderror
                            </label>
                        </div>

                        <div class="flex justify-center md:px-20 xl:px-20">
                            <label class="block mt-12">
                                <span class="text-gray-700">値段</span>
                                <input type="text" name="price" value="{{old('price')}}" class="w-44 block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30"></input>
                                @error('price')
                                <p class="w-44 text-red-500 text-sm">{{$message}}</p>
                                @enderror
                            </label>
                        </div>

                        <div class="flex justify-center md:px-20 xl:px-20">
                            <label class="block mt-12">
                                <span class="text-gray-700">数量</span>
                                <input type="number" name="number" value="{{old('number')}}" class="w-44 block rounded-md border-gray-300 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-30"></input>
                                @error('number')
                                <p class="w-44 text-red-500 text-sm">{{$message}}</p>
                                @enderror
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center mt-8 mb-20">
                    @can('user-higher') {{-- 一般権限以上に表示される --}}
                    <a href="/list" class="h-11 w-24 mr-2 py-2 text-center bg-blue-600 text-white font-semibold hover:opacity-75 rounded
                        mr-6 ml-2 md:mr-20 xl:mr-40">戻る</a>
                    @elsecan('guest') {{-- ゲストに表示される --}}
                    <a href="/guest/list" class="h-11 w-24 mr-2 py-2 text-center bg-blue-600 text-white font-semibold hover:opacity-75 rounded
                        mr-6 ml-2 md:mr-20 xl:mr-40">戻る</a>
                    @endcan

                    <button class="h-11 w-24 mr-2 py-2 text-center bg-blue-600 text-white font-semibold hover:opacity-75 rounded
                        ml-10 xl:-ml-8">登録</button>
                </div>
            </form>
    </div>
</x-app-layout>
