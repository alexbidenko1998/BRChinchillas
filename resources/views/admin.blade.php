<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>BRchinchillas</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.6/dist/vue.js"></script>
</head>
<body>

<div id="BRApp">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-6">
                <h1 class="h6 text-center">Шиншиллы</h1>
                <button class="btn btn-primary" @click="toAddChinchilla()"
                        data-toggle="modal" data-target="#redactChinchillaModal">Добавить</button>

                <div v-for="chinchilla in chinchillas" class="card" @click="openChinchilla(chinchilla.id)"
                     data-toggle="modal" data-target="#redactChinchillaModal">
                    <div class="row">
                        <div class="col-4" >
                            <img class="w-100" v-if="!!chinchilla.adultAvatar" :src="'/photos/chinchillas/' + chinchilla.adultAvatar">
                            <img class="w-100" v-else-if="!!chinchilla.babyAvatar" :src="'/photos/chinchillas/' + chinchilla.babyAvatar">
                        </div>
                        <div class="col-8">
                            <h6>@{{chinchilla.name_ru}}</h6>
                            <p>@{{chinchilla.description_ru}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <h1 class="h6 text-center">На продажу</h1>
                <button class="btn btn-primary" @click="toAddPurchase()"
                        data-toggle="modal" data-target="#redactPurchaseModal">Добавить</button>

                <div v-for="purchase in purchases" class="card" @click="openPurchase(purchase.id)"
                     data-toggle="modal" data-target="#redactPurchaseModal">
                    <div class="row">
                        <div class="col-8">
                            <h6>@{{chinchillaName(purchase.chinchillaId)}} - @{{purchase.rubles}} - @{{purchase.euros}}</h6>
                            <p>@{{purchase.description_ru}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="redactChinchillaModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Редактирование шиншиллы</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" v-if="redactedChinchilla != null">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Кличка шиншиллы" v-model="redactedChinchilla.name_ru">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Кличка шиншиллы" v-model="redactedChinchilla.name_en">
                    </div>
                    <div class="form-group">
                    <textarea type="text" class="form-control" placeholder="Описание шиншиллы"
                              v-model="redactedChinchilla.description_ru"></textarea>
                    </div>
                    <div class="form-group">
                    <textarea type="text" class="form-control" placeholder="Описание шиншиллы"
                              v-model="redactedChinchilla.description_en"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="date" class="form-control" placeholder="Дата рождения" v-model="redactedChinchilla.birthday">
                    </div>

                    <p>Взрослые изображения и аватарка</p>
                    <div class="position-relative">
                        <img v-if="!!redactedChinchilla.adultAvatar" :src="'/api/file/' + redactedChinchilla.adultAvatar" class="w-100 border">
                        <button @click="redactedChinchilla.adultAvatar = ''"
                                style="position: absolute; top: 0; right: 0;">Удалить</button>
                    </div>
                    <div class="row">
                        <div class="col-4 position-relative" v-for="(photo, index) in redactedChinchilla.adultPhotos">
                            <img :src="'/api/file/' + photo" class="w-100" @click="redactedChinchilla.adultAvatar = photo">
                            <button @click="removePhoto(index, true)"
                                    style="position: absolute; top: 0; right: 0;">Удалить</button>
                        </div>
                    </div>
                    <input type="file" multiple @change="uploadPhotos($event, 1)">

                    <p>Детские изображения и аватарка</p>
                    <div class="position-relative">
                        <img v-if="!!redactedChinchilla.babyAvatar" :src="'/api/file/' + redactedChinchilla.babyAvatar" class="w-100 border">
                        <button @click="redactedChinchilla.babyAvatar = ''"
                                style="position: absolute; top: 0; right: 0;">Удалить</button>
                    </div>
                    <div class="row">
                        <div class="col-4" v-for="photo in redactedChinchilla.babyPhotos">
                            <img :src="'/api/file/' + photo" class="w-100" @click="redactedChinchilla.babyAvatar = photo">
                            <button @click="removePhoto(index, false)"
                                    style="position: absolute; top: 0; right: 0;">Удалить</button>
                        </div>
                    </div>
                    <input type="file" multiple @change="uploadPhotos($event, 2)">

                    <div class="form-group">
                        <label>Мама</label>
                        <select class="form-control" v-model="redactedChinchilla.mother">
                            <option value="0">Не указано</option>
                            <option v-for="chinchilla in chinchillas" :value="chinchilla.id">@{{chinchilla.name_ru}}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Папа</label>
                        <select class="form-control" v-model="redactedChinchilla.father">
                            <option value="0">Не указано</option>
                            <option v-for="chinchilla in chinchillas" :value="chinchilla.id">@{{chinchilla.name_ru}}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Статус</label>
                        <select class="form-control" v-model="redactedChinchilla.status">
                            <option value="1">Малыш</option>
                            <option value="2">Взрослый</option>
                            <option value="3">Малыш и Взрослый</option>
                            <option value="4">Скрыт</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal" @click="deleteChinchilla()">Удалить</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" @click="saveChinchilla()">Сохранить</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="redactPurchaseModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Редактирование шиншиллы</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" v-if="redactedPurchase != null">
                    <div class="form-group">
                        <label>Шиншилла</label>
                        <select class="form-control" v-model="redactedPurchase.chinchillaId">
                            <option value="0">Не указано</option>
                            <option v-for="chinchilla in chinchillas" :value="chinchilla.id">@{{chinchilla.name_ru}}</option>
                        </select>
                    </div>
                    <div class="form-group">
                    <textarea type="text" class="form-control" placeholder="Товарное описание шиншиллы"
                              v-model="redactedPurchase.description_ru"></textarea>
                    </div>
                    <div class="form-group">
                    <textarea type="text" class="form-control" placeholder="Товарное описание шиншиллы"
                              v-model="redactedPurchase.description_en"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Цена в рублях" v-model="redactedPurchase.rubles">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Цена в евро" v-model="redactedPurchase.euros">
                    </div>
                    <div class="form-group">
                        <label>Статус</label>
                        <select class="form-control" v-model="redactedPurchase.status">
                            <option value="1">Продается</option>
                            <option value="2">В резерве</option>
                            <option value="3">Продана</option>
                            <option value="4">Скрыт</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal" @click="deletePurchase()">Удалить</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" @click="savePurchase()">Сохранить</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script type="text/javascript">
    const dateFormat = (date) => {
        if(!isNaN(date)) {
            let d = new Date(date).getDate();
            if (d < 10) d = "0" + d;
            let m = new Date(date).getMonth() + 1;
            if (m < 10) m = "0" + m;
            return new Date(date).getFullYear().toString() + "-" + m + "-" + d;
        } else {
            return date;
        }
    };

    const BRApp = new Vue({
        el: "#BRApp",
        data: {
            chinchillas: [],
            purchases: [],
            redactedChinchilla: null,
            redactedPurchase: null
        },
        created: function() {
            $.ajax({
                url: "/api/chinchillas",
                type: "GET",
                success(data) {
                    BRApp.chinchillas = data.sort((el1, el2) => {
                        if(el1.name > el2.name) return 1;
                        else return -1;
                    });
                }
            });
            $.ajax({
                url: "/api/purchases",
                type: "GET",
                success(data) {
                    BRApp.purchases = data;
                }
            });
        },
        methods: {
            toAddChinchilla: function () {
                this.redactedChinchilla = {
                    id: null,
                    name_ru: "",
                    name_en: "",
                    description_ru: "",
                    description_en: "",
                    birthday: "2019-07-21",
                    adultAvatar: "",
                    babyAvatar: "",
                    adultPhotos: [],
                    babyPhotos: [],
                    mother: 0,
                    father: 0,
                    status: 1
                };
            },
            openChinchilla: function (id) {
                this.redactedChinchilla = Object.assign({}, this.chinchillas.find(el => el.id === id));
                console.log(this.redactedChinchilla);
                this.redactedChinchilla.birthday = dateFormat(this.redactedChinchilla.birthday);
            },
            uploadPhotos: function (event, which) {
                let photos = event.target.files;
                console.log(event);
                for (let file of photos) {
                    const fr = new FileReader();
                    fr.onload = () => {
                        let fd = new FormData();
                        fd.append("photo", fr.result.toString());
                        fetch('/api/file', {
                            method: 'POST',
                            body: fd
                        }).then(response => response.json()).then(data => {
                            console.log(data);
                            if(which === 1) {
                                BRApp.redactedChinchilla.adultPhotos.push(data.filename);
                            } else {
                                BRApp.redactedChinchilla.babyPhotos.push(data.filename);
                            }
                        });
                    };
                    fr.readAsDataURL(file);
                }
            },
            removePhoto: function(index, isAdult) {
                if(isAdult) {
                    this.redactedChinchilla.adultPhotos.splice(index, 1);
                } else {
                    this.redactedChinchilla.babyPhotos.splice(index, 1);
                }
            },
            saveChinchilla: function () {
                this.redactedChinchilla.birthday = new Date(this.redactedChinchilla.birthday).getTime();
                let url;
                let type;
                if (this.redactedChinchilla.id != null) {
                    url = "/api/chinchillas/" + this.redactedChinchilla.id;
                    type = "PUT";
                } else {
                    url = "/api/chinchillas";
                    type = "POST";
                }
                $.ajax({
                    url: url,
                    type: type,
                    data: JSON.stringify(this.redactedChinchilla),
                    contentType: 'application/json; charset=utf-8',
                    dataType: 'json',
                    success() {
                        $.ajax({
                            url: "/api/chinchillas",
                            type: "GET",
                            success(data) {
                                BRApp.chinchillas = data.sort((el1, el2) => {
                                    if(el1.name > el2.name) return 1;
                                    else return -1;
                                });
                            }
                        });
                    }
                });
            },
            toAddPurchase: function() {
                this.redactedPurchase = {
                    id: null,
                    chinchillaId: 0,
                    description_ru: "",
                    description_en: "",
                    rubles: 0,
                    euros: 0,
                    status: 1
                };
            },
            openPurchase: function (id) {
                this.redactedPurchase = Object.assign({}, this.purchases.find(el => el.id === id));
            },
            savePurchase: function () {
                let url;
                let type;
                if (this.redactedPurchase.id != null) {
                    url = "/api/purchases/" + this.redactedPurchase.id;
                    type = "PUT";
                } else {
                    url = "/api/purchases";
                    type = "POST";
                }
                $.ajax({
                    url: url,
                    type: type,
                    data: JSON.stringify(this.redactedPurchase),
                    contentType: 'application/json; charset=utf-8',
                    dataType: 'json',
                    success() {
                        $.ajax({
                            url: "/api/purchases",
                            type: "GET",
                            success(data) {
                                BRApp.purchases = data;
                            }
                        });
                    }
                });
            },
            chinchillaName: function(id) {
                return this.chinchillas.find(el => el.id === id).name_ru;
            },
            deleteChinchilla: function() {
                $.ajax({
                    url: "/api/chinchillas/" + BRApp.redactedChinchilla.id,
                    type: "DELETE",
                    success(data) {
                        BRApp.chinchillas = BRApp.chinchillas.filter(el => el.id !== BRApp.redactedChinchilla.id);
                    }
                });
            },
            deletePurchase: function() {
                $.ajax({
                    url: "/api/purchases/" + BRApp.redactedPurchase.id,
                    type: "DELETE",
                    success(data) {
                        BRApp.purchases = BRApp.purchases.filter(el => el.id !== BRApp.redactedPurchase.id);
                    }
                });
            }
        }
    })
</script>
</body>
</html>
