<template>
  <div>
    <div class="search-block">
      <Searchbar
        v-model="input"
        class="search-block__searchbar"
        @on-submit="submitSearch"
      />
      <Filters
        v-model="filters"
        :columns="options.columns"
        class="search-block__filters"
      />
    </div>
    <div v-loading="loading" class="results">
      <Table
        v-if="items.length > 0"
        class="results__table table"
        :columns="options.columns"
        :items="items"
      />
      <el-alert
        v-else
        class="results__message"
        :title="messages.empty.title"
        type="info"
        :description="messages.empty.description"
        show-icon
      />
    </div>
  </div>
</template>

<script>
import Axios from 'axios'
// Import columns options from file. It's good practice for SOLID development.
import searchTableColumns from '~/assets/options/searchTableColumns.json'

export default {
  components: {
    Searchbar: () => import('~/components/Searchbar'),
    Filters: () => import('~/components/Filters'),
    Table: () => import('~/components/Table')
  },
  data: () => ({
    input: '',
    filters: '',
    loading: false,
    messages: {
      empty: {
        title: 'Warning!',
        description: 'No results were found. Input something in searchbar or change your search params, and then push "Search" button.'
      }
    },
    options: {
      columns: searchTableColumns
    },
    items: []
  }),
  methods: {
    prepareParams () {
      // Preparing the request parameters before sending
      const { input, filters } = this
      return {
        input,
        ...filters
      }
    },
    async submitSearch () {
      const params = this.prepareParams()
      this.loading = true

      // Use async/await technic to fetch data from DB with API request
      try {
        const { data } = await Axios.get('api/search', { params })
        this.items = data
      } catch (e) {
        // Good practice to display error
        console.log(e)
      } finally {
        this.loading = false
      }
    }
  }
}
</script>

<style lang="scss" scoped>
.search-block {
  & > *:not(:last-child) {
    position: relative;
    margin-bottom: 16px;
  }
}
</style>
