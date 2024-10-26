           
           
            <!-- Phần Table -->
            <div class="sm:col-span-7 sm:mt-2 mb-2 flex flex-col">
                <div class="p-1 flex justify-start sm:mx-4">
                    <h1 class="text-lg font-semibold pl-2 text-slate-800"> Danh sách thành viên </h1>
                </div>

                <div class="border-2 rounded-md mt-1 sm:mx-5 relative h-full bg-white overflow-auto 
                            shadow-md rounded-lg bg-clip-border custom-scrollbar">
                    <table class="w-full text-left table-auto">
                        <thead >
                            <tr>
                                <th class="p-3 border-b border-slate-200 bg-slate-100"> ID </th>
                                <th class="p-3 border-b border-slate-200 bg-slate-100"> Họ và tên </th>
                                <th class="p-3 border-b border-slate-200 bg-slate-100"> Ngày sinh </th>
                                <th class="p-3 border-b border-slate-200 bg-slate-100"> Giới tính </th>
                                <th class="p-3 border-b border-slate-200 bg-slate-100"> Email </th>
                            </tr>
                        </thead>
                        <tbody id="table1">
                            <!-- Xử lý ở đây -->
                            <?php 
                                $count = 0;
                                $sex = '';
                                foreach ($list as $value) {
                                    switch ($value->Sex) {
                                        case 1: $sex = 'Nam'; break;
                                        case 2: $sex = 'Nữ' ; break;
                                        default: $sex = 'Khác'; break;
                                    }
                                if($count % 2 != 0){ ?>
                                    <tr class='hover:bg-slate-50 border-b bg-blue-100 border-slate-200'>
                                        <td class='p-3 py-2'> <?php echo $value->ID ?> </td>
                                        <td class='p-3 py-2'> <?php echo $value->Name ?> </td>
                                        <td class='p-3 py-2'> <?php echo $value->BirthDay ?> </td>
                                        <td class='p-3 py-2'> <?php echo $sex ?> </td>
                                        <td class='p-3 py-2'> <?php echo $value->Email ?> </td>
                                    </tr>
                                <?php    }else{ ?>
                                    <tr class='hover:bg-slate-50 border-b border-slate-200'>
                                    <td class='p-3 py-2'> <?php echo $value->ID ?> </td>
                                        <td class='p-3 py-2'> <?php echo $value->Name ?> </td>
                                        <td class='p-3 py-2'> <?php echo $value->BirthDay ?> </td>
                                        <td class='p-3 py-2'> <?php echo $sex ?> </td>
                                        <td class='p-3 py-2'> <?php echo $value->Email ?> </td>
                                    </tr>
                                <?php }
                                $count++;
                                }
                            ?>
                        </tbody>
                    </table>

                    <div class="flex flex-row justify-between">
                        <div id="total" class="mt-5 flex justify-start ml-4 m-5">
                                <!-- total -->
                        </div>

                        <!-- Phân trang -->
                        <div id="pagi" class="flex mr-4 m-5">
                        <!-- Xử lý ở đây -->
                            <?php
                            for($i = 1; $i <= $paginate; $i++){
                                if($i > 3 && $i < $paginate){
                                    if ($i > 3 && $i < 5){
                                        echo"<ul class='flex space-x-2'>
                                        <li class='page-item' >
                                        <p class='page-link px-4 pb-2 
                                        text-gray-700'> . . . </p>
                                        </li>
                                        </ul>";
                                    }else{
                                        continue;
                                    }
                                }else{
                                    echo "<ul class='flex space-x-2'>
                                    <li class='page-item'>
                                   
                                        <a class='page-link px-4 py-2 border border-gray-300 
                                        rounded hover:bg-gray-200 text-gray-700' href=" .base_url("page/". $i)  .">" . $i . "</a>
                                    </li>
                                    </ul>";
                                }
                            }
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    