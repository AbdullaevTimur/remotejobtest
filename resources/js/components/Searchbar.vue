<template>
  <div class="searchbar">
    <el-input
      v-model="input"
      class="searchbar__input"
      :placeholder="placeholder"
      prefix-icon="el-icon-search"
    >
      <el-button
        slot="append"
        icon="el-icon-search"
        class="serachbar__toolbar"
        @click="$emit('on-submit')"
        v-text="label"
      />
    </el-input>
  </div>
</template>

<script>
export default {
  props: {
    placeholder: {
      type: String,
      default: 'Type something... (Searching by name)'
    },
    label: {
      type: String,
      default: 'Search'
    }
  },
  data () {
    return {
      input: ''
    }
  },
  watch: {
    input (newValue, oldValue) {
      if (newValue !== oldValue) {
        this.$emit('input', newValue)
      }
    }
  }
}
</script>
