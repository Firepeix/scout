@php /** @var \Scout\Book\Domain\Book $book */ @endphp
@extends('layout.app')
@section('content')
    <v-card outlined>
        <v-app-bar flat class="has-bottom-border">
            <v-toolbar-title class="text-h6 pl-0">
                Livros
            </v-toolbar-title>

            <v-spacer></v-spacer>

            <v-btn @click="cleanLogs" :loading="loading.cleanLogs" :disabled="loading.cleanLogs" color="primary">
                Limpar Logs
            </v-btn>
        </v-app-bar>
        <div class="card-content">
            <v-simple-table>
                <template>
                    <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Nome</th>
                        <th class="text-center">Capitulo</th>
                        <th class="text-center">Ignorado Até</th>
                        <th class="text-center">Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($books as $book)
                        <tr>
                            <td class="text-center">{{ $book->getId() }}</td>
                            <td class="text-center">{{ $book->getTitle() }}</td>
                            <td class="text-center">{{ $book->getLastChapterRead() }}</td>
                            <td class="text-center">{{ $book->getIgnoredUntil() !== null ? $book->getIgnoredUntil()->format('d/m/Y') : 'Ativo'}}</td>
                            <td class="text-center">
                                <v-tooltip top color="black">
                                    <template #activator="{ on, attrs }">
                                        <v-btn color="success" icon v-bind="attrs" v-on="on">
                                            <v-icon>mdi-check</v-icon>
                                        </v-btn>
                                    </template>
                                    <span>Marcar como lido!</span>
                                </v-tooltip>
                                @if($book->getIgnoredUntil() !== null)
                                    <v-tooltip top color="black">
                                        <template #activator="{ on, attrs }">
                                            <v-btn color="purple" icon v-bind="attrs" v-on="on">
                                                <v-icon>mdi-play</v-icon>
                                            </v-btn>
                                        </template>
                                        <span>Ativar!</span>
                                    </v-tooltip>
                                @else
                                    <v-tooltip top color="black">
                                        <template #activator="{ on, attrs }">
                                            <v-btn @click="postpone({{$book->getId()}})" :loading="loading.postpone" :disabled="loading.postpone" color="primary" icon v-bind="attrs" v-on="on">
                                                <v-icon>mdi-calendar-plus</v-icon>
                                            </v-btn>
                                        </template>
                                        <span>Adiar para depois!</span>
                                    </v-tooltip>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </template>
            </v-simple-table>
        </div>
    </v-card>
@endsection
@push('script')
    <script>
      new Vue({
        el: '#app',
        data: {
          loading: {
            cleanLogs: false,
            postpone: false,
            markAsRead: false
          }
        },
        mixins: [window.alerts],
        vuetify: new Vuetify(),
        methods: {
          async cleanLogs () {
            try {
              this.loading.cleanLogs = true;
              const response = await axios.delete(`${window.ENV.URL}/logs`);
              this.loading.cleanLogs = false;
              if (response.data.success) {
                this.displaySuccess('Logs Limpos!');
                return;
              }
              this.displayError();
            } catch (error) {
              this.loading.cleanLogs = false;
              this.displayError(error.message);
            }
          },
          async postpone (id) {
            try {
              this.loading.postpone = true;
              const response = await axios.put(`${window.ENV.URL}/books/${id}/postpone`);
              this.loading.postpone = false;
              if (response.data.success) {
                this.displaySuccess('Capitulo Adiado!');
                return;
              }
              this.displayError();
            } catch (error) {
              this.loading.postpone = false;
              this.displayError(error.message);
            }
          }
        }
      });
    </script>
@endpush
