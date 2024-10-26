<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Sử dụng cdn để nhúng jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!--  -->
    <!-- <script src="./assets/index.js"></script> -->
    <script src="<?php echo base_url('application/assets/index.js'); ?>"></script>

    <title> Nhập thông tin </title>
    

</head>

<body class="bg-blue-100">
    <div class="">
        <div id="header" class="border-2 bg-opacity-30 bg-green-500 p-5">
            <h1 class="flex justify-center text-xl"> Xin chào đến với Hoàng Anh Channel! </h1>
        </div>

        <div id="content" class="grid grid-col-1 sm:grid-cols-12 border-b border-gray-900/10">
             <!-- Phần Forrm -->
            <div id="form" class="sm:col-span-5 pb-8 mt-7">
                <form id="personForm" method="post" onsubmit="addmember(event);" 
                        class="mt-5 mx-5 bg-blue-300 border-2 border-dashed rounded-md">
                    <div class=" ">
                        <div class="">
                            <h1 class="mt-10 text-2xl font-semibold leading-7 text-gray-900 flex items-center justify-center" > Input Information </h1> 
                            <p class="text-sm leading-6 text-gray-600 flex justify-center"> (Mời bạn nhập thông tin) </p>
                        </div>    

                        <div class="mx-2">
                            <div class="mb-2 sm:mt-8 grid grid-cols-1 gap-x-6 sm:grid-cols-8">
                                <div class="col-span-2">
                                    <label class="block text-base text-3xl font-medium leading-8 text-gray-900" for="ipname"> Họ và tên: </label>
                                </div>
                                <div class="col-span-4">
                                    <input type="text" class="pl-3 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm 
                                                        ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
                                                        focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" name="name" 
                                                        oninput="keychange()" id="ipname" placeholder="Nhập vào đây">
                                </div>

                                <!-- Thông báo -->
                                <div class="col-span-2 mt-2">
                                    <span id="err-name" class="text-red-500 text-sm"> * </span>
                                </div>
                            </div>

                            <div class="mb-2 mt-2 grid grid-col-1 gap-x-6 sm:grid-cols-8">
                                <div class="col-span-2">
                                    <label class="block text-base text-3xl font-medium leading-8 text-gray-900" for="ipbirth"> Ngày sinh: </label>
                                </div>
                                <div class="col-span-4">
                                    <input type="date" class="pl-3 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm
                                                        ring-1 ring-inset ring-gray-300
                                                        focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" name="birth" 
                                                        oninput="keychange()" id="ipbirth">
                                </div>

                                <!-- Thông báo -->
                                <div class="col-span-2 mt-2">
                                    <span id="err-birth" class="text-red-500 text-sm"> * </span>
                                </div>
                            </div>

                            <div class="mb-2 mt-2 grid grid-col-1 gap-x-6 sm:grid-cols-8">
                                <div class="col-span-2">
                                    <label class="block text-base text-3xl font-medium leading-7 text-gray-900" for="ipsex"> Giới tính: </label>
                                </div>
                                <div class="col-span-4 py-1">
                                    <input type="radio" class="ml-2" onclick="keychange()" name="sex" id="ipsex" value="Nam">Nam
                                    <input type="radio" class="ml-3" onclick="keychange()" name="sex" id="ipsex1" value="Nữ">Nữ
                                    <input type="radio" class="ml-3" onclick="keychange()" name="sex" id="ipsex2" value="Khác">Khác
                                </div>

                                <!-- Thông báo -->
                                <div class="col-span-2 mt-2">
                                    <span id="err-sex" class="text-red-500 text-sm"> * </span>
                                </div>
                            </div>

                            <div class="mb-2 mt-2 grid grid-col-1 gap-x-6 sm:grid-cols-8">
                                <div class="col-span-2">
                                    <label class="block text-base text-3xl font-medium leading-7 text-gray-900" for="ipemail"> Email: </label>
                                </div>
                                <div class="col-span-4">
                                    <input type="email" class="pl-3 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm
                                                        ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
                                                        focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" name="email"
                                                        oninput="keychange()" id="ipemail" placeholder="Nhập vào đây">
                                </div>

                                <!-- Thông báo -->
                                <div class="col-span-2 mt-2">
                                    <span id="err-email" class="text-red-500 text-sm"> * </span>
                                </div>
                            </div>
                            <h3 id="success"></h3>
                        </div>

                        <div class="sm:mt-5 flex flex-row gap-y-2 p-2 justify-end">
                            <div class="">
                                <input class="mx-2 rounded-md bg-indigo-600 px-3 py-2 text-xl font-semibold text-white
                                            shadow-sm hover:bg-indigo-400 hover:text-black focus-visible:outline focus-visible:outline-2 
                                            focus-visible:outline-offset-2 focus-visible:outline-indigo-600" type="submit" value="Hoàn thành">
                            </div>
                            <div>
                                <input id="test" class=" rounded-md hover:bg-gray-400 hover:bg-opacity-30 text-xl p-2 font-semibold
                                            hover:text-red-700 leading-6 text-gray-700" type="reset" onclick="huyForm()" value="Hủy">
                            </div>
                        </div>
                    </div>
                </form>

        <!-- Bộ office -->
            <?php
            // Sử dụng biểu thức chính quy để lấy số
                preg_match('/\/page\/(\d+)/', $url, $matches);
                // 
                if (isset($matches[1])) {
                    $i = (int)$matches[1]; // Chuyển đổi sang số nguyên
                } else {
                    $i = 1;
                }
            ?>
                <div id="office" class="mt-5 mx-10 flex justify-end">
                    <a href="<?php echo base_url('exportexcel/' . $i); ?>" class="relative inline-flex items-center justify-start 
                    px-6 py-3 overflow-hidden font-medium transition-all bg-white rounded hover:bg-white group">
                    <span class="w-48 h-48 rounded rotate-[-40deg] bg-purple-600 absolute bottom-0 left-0 
                    -translate-x-full ease-out duration-500 transition-all translate-y-full mb-9 ml-9 
                    group-hover:ml-0 group-hover:mb-32 group-hover:translate-x-0">
                    </span> 
                    <span class="relative w-full text-left text-black transition-colors duration-300 ease-in-out group-hover:text-white">
                        Tải FILE Exel
                    </span> 
                    </a>

                    <button id="btnDocx" 
                    class="border-2 border-black rounded-lg hover:text-white 
                        hover:bg-gradient-to-r from-sky-500 to-indigo-500 bg-green-100 p-3 ml-4"> 
                    <a href="<?php echo base_url('export/' . $i); ?>">
                        Tải FILE Word
                    </a>
                    </button>

                    <button id="btnpdf" class="relative inline-block text-lg group ml-4"> 
                    <span class="relative z-10 block px-5 py-3 overflow-hidden font-medium leading-tight text-gray-800 
                    transition-colors duration-300 ease-out border-2 border-gray-900 rounded-lg group-hover:text-white"> 
                    <span class="absolute inset-0 w-full h-full px-5 py-3 
                    rounded-lg bg-gray-50">
                    </span> 
                    <span class="absolute left-0 w-48 h-48 -ml-2 transition-all duration-300 origin-top-right -rotate-90
                    -translate-x-full translate-y-12 bg-gray-900 group-hover:-rotate-180 ease">
                    </span> 
                    <a href="<?php echo base_url('exportpdf/' . $i); ?>">
                        <span class="relative">Tải FILE PDF</span> 
                    </a>
                    </span> 
                    <span class="absolute bottom-0 right-0 w-full h-12 -mb-1 -mr-1 transition-all duration-200 ease-linear
                    bg-gray-900 rounded-lg group-hover:mb-0 group-hover:mr-0" data-rounded="rounded-lg">
                    </span> 
                    </button>
                </div>

            </div>