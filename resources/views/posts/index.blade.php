@extends('layouts.app')
@section('content')
    <div class="container" id="cont_app">
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="userName">Nombre del usuario</label>
                    <input id="userName" type="text" class="form-control" v-model="nameUser">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <h3 class="text-success text-center" v-if="nameUser">
                    @{{ nameUser }} @{{ message }}
                </h3>
                <h3 class="text-danger text-center" v-if="!nameUser">No hay ningun usuario</h3>
            </div>
        </div>
        <div class="col-9">
            <button class="btn btn-success" data-toggle="modal" data-target="#add_modal">
                <i class="fa fa-plus"></i>
            </button>
        </div>
        <div class="row justify-content-center">

            <div class="col-9 mb-2" v-for="post in posts">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title ">@{{ post.title }}</h5>
                        <p class="card-text">
                            @{{ post.content }}
                        </p>
                    </div>
                    <div class="card-footer">
                        <div class="row justify-content-center">
                            <div class="col-4 text-muted">
                                Creador: @{{ post.creator_user }}
                            </div>
                            <div class="col-2">
                                <div class="text-danger">

                                    <a href="#!" @click="likePost(post)" class="text-danger">
                                        <i class="fa fa-2x" :class="[post.isLike?'fa-heart':'fa-heart-o']"></i>
                                        <span class="badge badge-light"> @{{ post.likes }}</span>
                                    </a>
                                </div>
                            </div>
                            <div class="col-2 text-muted">
                                <div class="text-success">
                                    <a href="#!" @click="postActive=post.id"><i class="fa fa-comment-o fa-2x"></i></a>
                                </div>
                            </div>
                            <div class="col-2 text-muted">
                                <div class="text-success">
                                    <i class="fa fa-clock-o fa-2x"></i><span class=" badge badge-light">
                                            @{{ post.created_at }}
                                         </span>
                                </div>
                            </div>
                            <div class="col-2 text-muted">
                                <div class="text-danger">
                                    <a href="#!" class="text-danger" data-toggle="modal" data-target="#delete_modal" @click="idPost=post.id"><i class="fa fa-trash fa-2x"></i><span class=" badge badge-light">
                                    </span></a>
                                </div>
                            </div>
                            <div class="col-2 text-muted">
                                <div class="text-danger">
                                    <a href="#!" class="text-primary" data-toggle="modal" data-target="#update_modal" @click="editPost(post)"><i class="fa fa-edit fa-2x"></i><span class=" badge badge-light">
                                    </span></a>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center" v-if="postActive==post.id">

                            <div class="col-10" v-for="response in post.get_responses">
                                <div class="alert alert-dark">
                                  @{{ response.content }}
                                </div>
                            </div>
                            <div class="col-10" v-if="!post.get_responses.length">
                                <div class="alert alert-dark">
                                   <h5 class="text-danger">No existen comentarios</h5>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <pre>
            @{{ $data }}
        </pre>
        @include("posts.partials.add")
        @include("posts.partials.delete")
        @include("posts.partials.update")

    </div>
@endsection
@section("scripts")
    <script>
        new Vue({
            el: "#cont_app",
            created: function () {
                this.getPosts();
            },
            data: {
                api: "{{url("api/posts")}}/",
                apiLike:"{{url("api/likes")}}/",
                message: "Hola desde Vue.js",
                nameUser: "",
                postActive:null,
                posts: [],
                titlePost:"",
                descriptionPost:"",
                idPost:null,
               // fullPost:[],
                editTitle:"",
                editContent:"",


            },
            methods: {
                getPosts: function () {
                    axios.get(this.api).then(response => {
                        this.posts = response.data;
                    })
                },
                createPost:function(){},
                deletePost:function(){
                   axios.delete(this.api+this.idPost).then(response=>{
                       this.getPosts();
                   })
                },
                editPost:function(post){
                    this.editTitle=post.title;
                    this.editContent=post.content;
                    this.idPost=post.id;
                },
                updatePost:function(){
                    axios.put(this.api+this.idPost,{title:this.editTitle,content:this.editContent}).then(response=>{
                        this.getPosts();
                    })
                },
                likePost:function(post){
                    axios.post(this.apiLike,{post_id:post.id}).then(()=>{
                        this.getPosts()
                    })
                }
            }

        });
    </script>
@endsection
