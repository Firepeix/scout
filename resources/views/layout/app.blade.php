<!DOCTYPE html>
<html lang="pt" class="has-navbar-fixed-top">
<head>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="{{asset('css/vuetify.min.css')}}" rel="stylesheet">
    <script src="{{asset('js/axios.min.js')}}"></script>
    <script src="{{asset('js/moment.js')}}"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
    <title>Scout</title>
    <link rel="stylesheet" href="{{ asset('/app/main.css')  }}">
</head>
<body>
<div id="app">
    <v-app>
        <v-app-bar color="red" dark>
            <v-app-bar-nav-icon></v-app-bar-nav-icon>
            <v-toolbar-title>Scout</v-toolbar-title>
        </v-app-bar>

        <v-main style="padding-top: 1.5rem">
            <v-container>
                <v-row>
                    <v-col>
                        @yield('content')
                    </v-col>
                </v-row>
            </v-container>
            <v-snackbar :timeout="2500" color="success" v-model="successBar.status">
                <v-icon>mdi-check-circle</v-icon> @{{ successBar.message }} @{{snackMessage}}
            </v-snackbar>
            <v-snackbar :timeout="2500" color="red" v-model="errorBar.status">
                <v-icon>mdi-close-circle</v-icon> @{{ errorBar.message }} @{{snackMessage}}
            </v-snackbar>
        </v-main>
    </v-app>
</div>
<script src="{{asset(config('app.env') === 'production' ? 'js/vue.min.js' : 'js/vue.js')}}"></script>
<script src="{{asset(config('app.env') === 'production' ? 'js/vuetify.min.js' : 'js/vuetify.js')}}"></script>
<script>
    window.ENV = {
      URL: window.location.href.replace(/\/$/, '')
    }

    window.alerts = {
      data: {
        snackMessage: '',
        successBar: {
          status: false,
          message: 'Sucesso: '
        },
        errorBar: {
          status: false,
          message: 'Erro: '
        }
      },
      methods: {
        displayError (message = 'Ops, Algo de errado não esta certo!') {
          this.snackMessage = message;
          this.errorBar.status = true;
        },

        displaySuccess (message) {
          this.snackMessage = message;
          this.successBar.status = true;
        }
      }
    }
</script>
@stack('script')
</body>
</html>
