<div class="card ">
    <div class="card-header">
        <div class="card-body ">
            <div class="card-tools">
                <form action="<?= base_url() ?>user.index" method='get' autocomplete="off">
                    <input type="hidden" name="waiting" value="{{ request()->query('waiting') }}">
                    <div class="form-row col-md-12">
                        <div class="form-group col-md-3">
                            <input autocomplete="off" type="text" class="form-control" name="name" value="" placeholder="نام و نام خانوادگی">
                        </div>
                        <div class="form-group col-md-3">
                            <input autocomplete="off" type="text" class="form-control" name="national_code" value="" placeholder="کد ملی">
                        </div>
                        <div class="form-group col-md-3">
                            <input autocomplete="off" type="text" class="form-control" name="phone" value="" placeholder="شماره همراه">
                        </div>
                        <div class="form-group col-md-3">
                            <input autocomplete="off" type="text" class="form-control" name="email" value="" placeholder="ایمیل">
                        </div>
                    </div>
                    <div class="form-row col-md-12">
                        <div class="form-group col-md-3">
                            <input autocomplete="off" type="text" class="form-control" name="code" value="" placeholder="شناسه کاربر">
                        </div>
                        <div class="form-group col-md-3">
                            <input autocomplete="off" type="text" class="form-control" name="user_id" value="" placeholder="tblid کاربر">
                        </div>

                    </div>
                    <div class="form-row col-md-12">
                        <div class="offset-md-9"></div>
                        <div class="form-group col-md-1 "">
                    <a class=" mr-1 btn btn-danger btn-block" href="<?= base_url() ?>user.index">
                            <i class="fa fa-times"></i>
                            </a>
                        </div>
                        <div class="form-group col-md-2 vertical-align">
                            <button type="submit" name='search' value='1' class="mr-2 btn btn-success btn-block vertical-align d-flex justify-content-between align-items-center">
                                <span> جستجو موارد</span> <i class="fa fa-search vertical-align"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="p-0 card-body table-responsive">
        <table class="table table-hover">
            <thead>
                <div class="m-2 text-left">
                    <span>15 تا 1</span>
                    <span></span>
                    / <span>1300 مورد</span>
                </div>
            </thead>
            <tbody>
                <tr>
                    <th class="text-center">شناسه</th>
                    <th>مشخصات</th>
                    <th>اطلاعات ورود</th>
                    <th>نشانی</th>
                    <th>عملیات</th>
                </tr>
                <?php if ($users) : ?>
                    <?php foreach ($users as $value) : ?>
                        <tr class="vertical-align">
                            <td class="text-center" width="10px"><?= $value['id']  ?></td>
                            <td>
                                <div>
                                    <small>نام و خانوادگی:</small>
                                    <small><?= $value['first_name'] ?? ' - '  ?></small>
                                    <small><?= $value['last_name'] ?? ' - '  ?></small>
                                </div>
                                <div>
                                    <small>موبــــــایل: <?= $value['phone'] ?></small>
                                </div>
                                <div>
                                    <small>ایــــــــمیـل: <?= $value['email'] ?? ' - '  ?></small>
                                </div>
                                <div>
                                    <small>کد مـــلی: <?= $value['national_code'] ?? ' - '  ?></small>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <small>آخـــــرین ورود: </small>
                                    <small>
                                        <bdi class="arabic-num"> - </bdi>
                                    </small>
                                </div>
                                <div>
                                    <small>وضعیت کاربر: </small>
                                    <?php if ($value['status'] == 1) : ?>
                                        <i class="fa fa-check text-success"></i>
                                    <?php else : ?>
                                        <i class="fa fa-times text-danger"></i>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <?php if ($value['user_level'] == 1) : ?>

                                        <small>ثبت نام اولیه:</small>
                                        <i class="fa fa-star-o text-lighter"></i>
                                    <?php elseif ($value['user_level'] == 2) : ?>

                                        <small>نـــــــــــــــقــره ای: </small>
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star text-secondary"></i>
                                    <?php elseif ($value['user_level'] == 3) : ?>

                                        <small>طـــــــــــــــــــلایــی: </small>
                                        <i class="fa fa-star text-warning"></i>
                                        <i class="fa fa-star text-warning"></i>
                                        <i class="fa fa-star text-warning"></i>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <small>استان: </small>
                                    <small>
                                        <bdi class="arabic-num"><?= $value['province_name'] ?? ' - '  ?></bdi>
                                    </small>
                                </div>
                                <div>
                                    <small>شـــــهر: </small>
                                    <small>
                                        <bdi class="arabic-num"><?= $value['city_name'] ?? ' - '  ?></bdi>
                                    </small>
                                </div>
                                <div>
                                    <small>آدرس: </small>
                                    <small>
                                        <bdi class="arabic-num"><?= $value['address'] ?? ' - '  ?></bdi>
                                    </small>
                                </div>
                                <div>
                                    <small>کد پستی: </small>
                                    <small>
                                        <bdi class="arabic-num"><?= $value['postal_code'] ?? ' - '  ?></bdi>
                                    </small>
                                </div>
                            </td>
                            <td class="text-center ">
                                <?php if (can('super-admin')) { ?>
                                    <a href="<?= base_url() ?>admin/user/makeadmin/<?= $value['id'] ?>"><button href="" class="p-0 pl-2 pr-2 shadow-sm btn btn-info btn-sm" style=" border-radius: 18px;">
                                            تبدیل به ادمین
                                        </button></a><?php } ?>
                                <!-- Button trigger modal -->
                                <button href="" class="p-0 pl-2 pr-2 shadow-sm btn btn-warning btn-sm" style=" border-radius: 18px;" data-toggle="modal" data-target="#userEditModal<?= $value['id'] ?>">
                                    ویــرایـش
                                </button>
                                <!-- Modal -->
                                <div class="modal fade" id="userEditModal<?= $value['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <form action="<?= base_url() ?>admin/user/<?= $value['id'] ?>" method="post" class="p-1">
                                                    <input type="hidden" name="_method" value="patch" />
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label for="first_name" class="">نام </label>
                                                                <input type="text" name="user-first_name" value="<?= $value['first_name'] ?>" class="form-control " id="first_name">
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label for="last_name" class=""> نام خانوادگی</label>
                                                                <input type="text" name="user-last_name" value="<?= $value['last_name'] ?>" class="form-control " id="last_name">
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label for="national_code" class=""> کدملی </label>
                                                                <input type="text" name="user-national_code" value="<?= $value['national_code'] ?>" class="form-control " id="national_code">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="form-group ">
                                                                <label for="user-province_id" class="mr-2 user-label">استان:</label>
                                                                <select name="user-province_id" class="form-control" data-width="80%" id="user-province">
                                                                    <?php if (!isset($value['province_id'])) : ?>
                                                                        <option value="" disabled selected>انتخاب کنید</option>
                                                                    <?php endif; ?>
                                                                    <?php foreach ($provinces as $data) : ?>
                                                                        <option value="<?= $data['id'] ?>" <?= $value['province_id'] == $data['id'] ?  'selected' : ''  ?>><?= $data['name'] ?></option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col user-city-placeholder">
                                                            <label for="user-city_id">شهر:</label>
                                                            <select name="user-city_id" id="user-city" class="form-control" data-city-id="<?= $value['city_id'] ?? $value['city_id'] ?>">
                                                                <?php if (!isset($value['city_id'])) : ?>
                                                                    <option value="" disabled selected>ابتدا شهر را انتخاب کنید</option>
                                                                <?php endif; ?>

                                                            </select>
                                                        </div>
                                                        <div class="col">
                                                            <div class="form-group ">
                                                                <label for="user-postal_code">کد پستی </label>
                                                                <input name="user-postal_code" value="<?= $value['postal_code'] ?>" type="text" class="form-control" id="user-postal_code">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="form-group ">
                                                                <label for="user-address">آدرس </label>
                                                                <input name="user-address" value="<?= $value['address'] ?>" type="text" class="form-control" id="user-address">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="form-group ">
                                                                <label for="user-phone">شماره موبایل </label>
                                                                <input name="user-phone" value="<?= $value['phone'] ?>" type="text" class="form-control" id="user-phone" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="form-group ">
                                                                <label for="user-email">ایمیل </label>
                                                                <input name="user-email" value="<?= $value['email'] ?>" type="text" class="form-control" id="user-email">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="float-right pt-1 pb-4 form-check">
                                                        <input name="user-status" type="checkbox" value="1" class="form-check-input " id="user-status" <?= $value['status'] == 1 ? 'checked' : ''  ?>>
                                                        <label class="form-check-label" for="user-status">
                                                            وضعیت
                                                        </label>
                                                    </div>
                                                    <button type="submit" class="float-left btn btn-primary btn-block">ذخیره </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <form method="post" action="<?= base_url() ?>admin/user/<?= $value['id'] ?>" class="d-inline">
                                    <input type="hidden" name="_method" value="delete" />
                                    <input type="submit" class="p-0 pl-2 pr-2 shadow-sm btn btn-danger btn-sm" style="border-radius: 18px;" onclick="return confirm('آیا برای حذف اطلاعات اطمینان دارید');" value="حــــــــذف">
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr class="alert alert-secondary" role="alert">
                        <td colspan="10">
                            آیتمی برای نمایش وجود ندارد
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li class="page-item <?php if (pagination_count('users', 10, ['user_level' => 1]) + 1 == 1 || (isset($_GET['page']) && $_GET['page'] == 1) || !isset($_GET['page'])) echo "disabled" ?>">
                    <a class="page-link" href="<?= base_url() ?>admin/tag?page=<?php if (isset($_GET['page']) && $_GET['page'] > 1) echo $_GET['page'] - 1; ?> " aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>
                <?php for ($i = 0; $i <=  pagination_count('users', 10, ['user_level' => 1]); $i++) : ?>
                    <li class="page-item <?php if (isset($_GET['page']) && $_GET['page'] == ($i + 1)) echo "active"; else if (!isset($_GET['page']) && ($i + 1) == 1) echo "active" ?>">
                        <a class="page-link" href="<?= base_url() ?>admin/tag?page=<?= $i + 1 ?>"><?= $i + 1 ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?php if (pagination_count('users', 10, ['user_level' => 1]) + 1 == 1 || (isset($_GET['page']) &&  pagination_count('users', 10, ['user_level' => 1]) + 1  == $_GET['page'])) echo "disabled" ?>">
                    <a class="page-link" href="<?= base_url() ?>admin/tag?page=<?php if (isset($_GET['page'])) echo $_GET['page'] + 1; else echo 2 ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
            </ul>
        </nav>
        <span class="float-left">
            1.2.3.
        </span>
    </div>
</div>
<?php include(BASEPATH . "/App/Views/Backend/user/script.php") ?>