
<body>
<h3 class="my-5">لیست محصولات</h3>
<!--insert product by Modal-->
<div>
    <!-- Button trigger modal -->
    <button type="button" class="  btn-custom-success mb-5" data-bs-toggle="modal" data-bs-target="#exampleModal">
        افزودن محصول جدید
    </button>

    <!-- Modal -->
    <div class="modal fade " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">افزودن محصول جدید</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" id="insertProduct">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 mb-3">
                                <label for="productName" class="form-label">نام محصول</label>
                                <input type="text" class="form-control shadow-sm" id="productName" placeholder="نام محصول..." required>
                            </div>
                            <div class="col-sm-12 col-md-6 mb-3">
                                <label for="productBrand" class="form-label">برند</label>
                                <input type="text" class="form-control shadow-sm" id="productBrand" placeholder="برند محصول..." required>
                            </div>
                            <div class="col-sm-12 col-md-6 mb-3">
                                <label for="productModel" class="form-label">مدل</label>
                                <input type="text" class="form-control shadow-sm" id="productModel" placeholder="مدل محصول..." required>
                            </div>
                            <div class="col-sm-12 col-md-6 mb-3">
                                <label for="productPrice" class="form-label">قیمت</label>
                                <input type="text" class="form-control shadow-sm" id="productPrice" placeholder="قیمت محصول..." required>
                            </div>
                            <div class="col-sm-12 col-md-6 mb-3">
                                <label for="productStatus" class="form-label">وضعیت</label>
                                <select class="form-select form-select-sm" id="productStatus"
                                        aria-label="Small select example" required>
                                    <option>انتخاب کنید...</option>
                                    <option value="0">ناموجود</option>
                                    <option value="1">موجود</option>
                                </select>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-custom-secondary" data-bs-dismiss="modal">بستن</button>
                            <button type="submit" class="btn btn-success btn-custom-success">افزودن</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--edit product by Modal-->
<div>
    <!-- Modal -->
    <div class="modal fade" id="editProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ویرایش محصول</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" id="updateProduct">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 mb-3">
                                <label for="updateName" class="form-label">نام محصول</label>
                                <input type="text" class="form-control shadow-sm" id="updateName" placeholder="نام محصول..." required>
                            </div>
                            <div class="col-sm-12 col-md-6 mb-3">
                                <label for="updateBrand" class="form-label">برند</label>
                                <input type="text" class="form-control shadow-sm" id="updateBrand" placeholder="برند محصول..." required>
                            </div>
                            <div class="col-sm-12 col-md-6 mb-3">
                                <label for="updateModel" class="form-label">مدل</label>
                                <input type="text" class="form-control shadow-sm" id="updateModel" placeholder="مدل محصول..." required>
                            </div>
                            <div class="col-sm-12 col-md-6 mb-3">
                                <label for="updatePrice" class="form-label">قیمت</label>
                                <input type="text" class="form-control shadow-sm" id="updatePrice" placeholder="قیمت محصول..." required>
                            </div>
                            <div class="col-sm-12 col-md-6 mb-3">
                                <label for="updateStatus" class="form-label">وضعیت</label>
                                <select class="form-select form-select-sm" id="updateStatus"
                                        aria-label="Small select example" required>
                                    <option>انتخاب کنید...</option>
                                    <option value="0">ناموجود</option>
                                    <option value="1">موجود</option>
                                </select>
                            </div>
                            <input type="hidden" id="updateID">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-custom-secondary" data-bs-dismiss="modal">بستن</button>
                                <button type="submit" class="btn btn-success btn-custom-success">‌ذخیره تغییرات</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
<!--product table-->
<div class="container-fluid">
    <div class="row rounded">
        <div class="col-sm-12">
            <table class="table table-striped table-borderless shadow-lg rounded-3 ">
                <thead class="rounded table-info">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">نام محصول</th>
                    <th scope="col">برند</th>
                    <th scope="col">مدل</th>
                    <th scope="col">قیمت</th>
                    <th scope="col">وضعیت</th>
                    <th scope="col">عملیات</th>
                </tr>
                </thead>
                <tbody id="tableBody" class="">
                <?php $all_products = all_product();
                if ($all_products):
                    foreach ($all_products as $item):
                        ?>
                        <tr>
                            <th scope="row"><?php echo $item->ID ?></th>
                            <td><?php echo $item->p_name ?></td>
                            <td><?php echo $item->p_brand ?></td>
                            <td><?php echo $item->p_model ?></td>
                            <td ><?php echo$item->p_price  ?></td>
                            <td> <?php
                                switch ($item->p_status) {
                                    case 0:
                                        echo '<span class="badge bg-custom-danger custom-badge shadow-sm">نا موجود</span>';
                                        break;
                                    case 1:
                                        echo '<span class="badge bg-custom-success custom-badge shadow-sm">موجود</span>';
                                        break;
                                }
                                ?></td>
                            <td>
                                <i title="ویرایش محصول" class="bi bi-pencil update-product cursor-pointer" data-id="<?php echo $item->ID ?>"
                                   data-bs-toggle="modal" data-bs-target="#editProduct"></i>
                                <i title="حذف محصول" class="fas fa-times-circle text-custom-danger mx-2 delete-product cursor-pointer" data-id="<?php echo $item->ID ?>"
                                   id="delete-item-<?php echo $item->ID ?>"></i>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                <?php else: ?>
                    <tr class="alert alert-warning">تاکنون محصولی ثبت نشده است</tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>