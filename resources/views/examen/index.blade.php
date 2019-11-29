@extends('layouts.app')
@section('content')
    <h4>Mi examen</h4>
    <div class="row" id="vue_component">
        <div class="col-12">
            <pre>@{{ $data }}</pre>
        </div>
    </div>
@endsection
@section("scripts")
    <script type="text/javascript">



        //axios.defaults.headers.common['Access-Control-Request-Headers'] = null
        //axios.defaults.headers.common['Access-Control-Request-Method'] = null
       // axios.defaults.headers.common['Access-Control-Allow-Origin'] = "*";
        axios.defaults.headers.common['Access-Control-Allow-Origin'] = "*";
        axios.defaults.headers.common['Access-Control-Allow-Methods'] = '*';
        new Vue({
            el:"#vue_component",
           created:function(){

                },
            mounted:function(){
                this.getInfo();
            },
            data:{
                api:"http://api.plos.org/search",
                info_api:[],
            },
            methods:{
                getInfo:function(){

                    this.$http.get('https://api.coindesk.com/v1/bpi/currentprice.json',
                        {
                            headers: {
                                'Access-Control-Allow-Origin': 'http://api.plos.org',
                                'Access-Control-Allow-Methods': 'POST, GET, PUT, OPTIONS, DELETE',
                                'Access-Control-Allow-Headers': 'Access-Control-Allow-Methods, Access-Control-Allow-Origin, Origin, Accept, Content-Type',
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            }
                        }
                    ).then(response => {

                        // get body data
                        this.someData = response.body;

                    }, response => {
                        // error callback
                    });
                    /*

                   axios({
                       "method": "get",
                       "url":'https://api.coindesk.com/v1/bpi/currentprice.json',
                       headers: {
                           "Access-Control-Allow-Origin": "*",
                           'Content-Type': 'application/json',
                           'Accept': 'application/json',
                            'cache-control': 'no-cache',
                       }, crossDomain: true
                   }).then(response=>{
                       this.info_api=response;
                   }).catch(function(error) {
                       if (!error.status) {
                           console.log(error.request)
                       }
                   });

                     */


                }
            }
        });


    </script>
@endsection
