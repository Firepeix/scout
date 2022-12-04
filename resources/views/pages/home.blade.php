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
                    <tr v-for="book in books" :key="`book-${book.id}`">
                        <td class="text-center">@{{ book.id }}</td>
                        <td class="text-center">@{{ book.title }}</td>
                        <td class="text-center">@{{ book.lastChapterRead }}</td>
                        <td class="text-center">@{{ book.ignoredUntil !== null ? book.ignoredUntil : 'Ativo'}}</td>
                        <td class="text-center">
                            <v-tooltip top color="black">
                                <template #activator="{ on, attrs }">
                                    <v-btn @click="read(book.id)" :loading="loading.markAsRead" :disabled="loading.markAsRead" color="success" icon v-bind="attrs" v-on="on">
                                        <v-icon>mdi-check</v-icon>
                                    </v-btn>
                                </template>
                                <span>Marcar como lido!</span>
                            </v-tooltip>
                            <v-tooltip top color="black" v-if="book.ignoredUntil !== null">
                                <template #activator="{ on, attrs }">
                                    <v-btn @click="turnOn(book.id)" color="purple" :loading="loading.postpone" :disabled="loading.postpone" icon v-bind="attrs" v-on="on">
                                        <v-icon>mdi-play</v-icon>
                                    </v-btn>
                                </template>
                                <span>Ativar!</span>
                            </v-tooltip>
                            <v-tooltip top color="black" v-else="book.ignoredUntil === null">
                                <template #activator="{ on, attrs }">
                                    <v-btn @click="postpone(book.id)" :loading="loading.postpone" :disabled="loading.postpone" color="primary" icon v-bind="attrs" v-on="on">
                                        <v-icon>mdi-calendar-plus</v-icon>
                                    </v-btn>
                                </template>
                                <span>Adiar para depois!</span>
                            </v-tooltip>
                        </td>
                    </tr>
                    </tbody>
                </template>
            </v-simple-table>
        </div>
    </v-card>
@endsection
@push('script')
    <script>
      new Vue({
        el: '#wrap-app',
        data: {
          books: @json($books),
          loading: {
            cleanLogs: false,
            postpone: false,
            markAsRead: false
          }
        },
        mixins: [window.alerts],
        vuetify: new Vuetify(),
        mounted: () => load(),
        methods: {
          async cleanLogs () {
            try {
              this.loading.cleanLogs = true;
              const response = await axios.delete(`${window.ENV.URL}/logs`);
              this.loading.cleanLogs = false;
              this.displaySuccess(response.data.message);
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
              this.displaySuccess(response.data.message);
              this.postponeRow(id);
            } catch (error) {
              this.loading.postpone = false;
              this.displayError(error.message);
            }
          },
          postponeRow (id) {
            const books = this.books;
            const bookIndex = books.findIndex(book => book.id === id)
            if (bookIndex !== -1) {
              books[bookIndex].ignoredUntil = moment().add(1, 'y').format('DD/MM/YYYY')
              this.books = books;
            }
          },
          async turnOn (id) {
            try {
              this.loading.postpone = true;
              const response = await axios.put(`${window.ENV.URL}/books/${id}/turn-on`);
              this.loading.postpone = false;
              this.displaySuccess(response.data.message);
              this.turnOnRow(id);
            } catch (error) {
              this.loading.postpone = false;
              this.displayError(error.message);
            }
          },
          turnOnRow (id) {
            const books = this.books;
            const bookIndex = books.findIndex(book => book.id === id)
            if (bookIndex !== -1) {
              books[bookIndex].ignoredUntil = null
              this.books = books;
            }
          },
          async read (id) {
            try {
              this.loading.markAsRead = true;
              const response = await axios.put(`${window.ENV.URL}/books/${id}/read`);
              this.loading.markAsRead = false;
              this.displaySuccess(response.data.message);
              this.readRow(id);
            } catch (error) {
              this.loading.markAsRead = false;
              this.displayError(error.message);
            }
          },
          readRow (id) {
            const books = this.books;
            const bookIndex = books.findIndex(book => book.id === id)
            if (bookIndex !== -1) {
              books[bookIndex].lastChapterRead = this.guessTheAmountToRead(String(books[bookIndex].lastChapterRead))
              this.books = books;
            }
          },
          guessTheAmountToRead (amount) {
            const decimals = amount.split('.');
            const digits = Number(String(decimals[1] !== undefined ? decimals[1] : '').length) + 1;
            const digit = Number(String('1').padEnd(digits, '0'));
            return String(((amount * digit) + 1) / digit);
          }
        }
      });
    </script>
@endpush
