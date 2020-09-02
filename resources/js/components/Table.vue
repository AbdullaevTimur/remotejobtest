<template>
  <el-table
    :data="items"
    style="width: 100%"
  >
    <el-table-column
      v-for="(column, index) in columns"
      :key="index"
      :prop="column.prop"
      :label="column.label"
      :width="column.width"
    />
  </el-table>
</template>

<script>
export default {
  props: {
    columns: {
      type: Array,
      default: () => {
        return [
          {
            prop: 'date',
            label: 'Date',
            width: 180
          },
          {
            prop: 'name',
            label: 'Name',
            width: 180
          },
          {
            prop: 'address',
            label: 'Address',
            width: 180
          }
        ]
      }
    },
    items: {
      type: Array,
      default: () => {
        return []
      }
    }
  }
}
</script>
