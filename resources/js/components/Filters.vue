<template>
  <div v-if="Object.keys(inputs).length > 0" class="filter">
    <el-row class="filter__tooltip">
      <el-select
        v-model="filters"
        multiple
        filterable
        allow-create
        default-first-option
        :placeholder="placeholder"
        class="filter__select"
      >
        <el-option
          v-for="(option, index) in filterColumns"
          :key="index"
          :label="option.label"
          :value="option.prop"
        />
      </el-select>
    </el-row>
    <el-row :gutter="20" class="filter__row">
      <el-col
        v-for="(key, index) in enableFilters"
        :key="index"
        :span="detectColumnSpan(inputs[key].type)"
        class="filter__cell"
      >
        <div class="filter__headline headline">
          <div class="filter__caption">
            {{ key }}
          </div>
          <el-button
            type="danger"
            size="mini"
            circle
            class="headline__control"
            @click="removeFilter(key)"
            v-text="'-'"
          />
        </div>
        <el-input-number
          v-if="inputs[key].type === 'number'"
          v-model="inputs[key].value"
          size="small"
        />
        <el-slider
          v-else-if="inputs[key].type === 'range'"
          v-model="inputs[key].value"
          range
          show-stops
          :max="options.range.max"
          :step="options.range.step"
        />
      </el-col>
    </el-row>
  </div>
</template>

<script>
export default {
  props: {
    columns: {
      type: [Object, Array],
      default: () => []
    },
    value: {
      type: [String, Object],
      default: ''
    },
    placeholder: {
      type: String,
      default: 'Choose and add filters...'
    },
    defaults: {
      type: Object,
      default: () => {
        return {
          number: 0,
          range: [0, 1000000]
        }
      }
    },
    options: {
      type: Object,
      default: () => {
        return {
          range: {
            max: 1000000,
            step: 1000
          }
        }
      }
    }
  },
  data () {
    return {
      filters: [],
      inputs: {}
    }
  },
  computed: {
    filterColumns () {
      // return columns only with $filter arg = "true"
      return this.columns.filter(x => x.filter)
    },
    enableFilters () {
      return Object.keys(this.inputs).filter(x => this.filters.includes(x))
    }
  },
  watch: {
    inputs: {
      deep: true,
      handler (newValue) {
        this.updateModelValue(newValue)
      }
    },
    enableFilters (newValue, oldValue) {
      if (oldValue && newValue !== oldValue) {
        this.updateModelValue(this.inputs)
      }
    }
  },
  mounted () {
    this.buildFilters()
  },
  methods: {
    buildFilters (columns = this.filterColumns) {
      if (columns.length === 0) return
      // build filter inputs based on (arg = filterColumns). Use "reduce" function
      this.inputs = columns.reduce((acc, { prop, type, filter }) => {
        acc[prop] = {
          type,
          value: this.defaults[type]
        }
        return acc
      }, {})

      // Redraw component
      this.$nextTick(() => {
        this.$forceUpdate()
      })
    },
    detectColumnSpan (type) {
      // Detect column "span" varible using for "Element UI" layout
      switch (type) {
        default:
        case 'number':
          return 6
        case 'range':
          return 24
      }
    },
    updateModelValue (collection) {
      const output = Object.keys(collection).reduce((acc, key) => {
        const { value } = collection[key]
        // Check if value exist or equel "0"
        const isValidValue = value || value === 0
        if (isValidValue && this.enableFilters.includes(key)) {
          acc[key] = value
        }
        return acc
      }, {})

      // Emit the "output" to parent "v-model"
      this.$emit('input', output)
    },
    removeFilter (key) {
      // Remove and hide disabled filters
      const index = this.filters.findIndex(x => x === key)
      if (index > -1) {
        this.filters.splice(index, 1)
      }
    }
  }
}
</script>

<style lang="scss" scoped>
.filter {
  &__headline {
    font-size: 12px;
    color: rgba(black, 0.5);
    text-transform: capitalize;
    margin-bottom: 8px;
  }

  &__cell {
    margin-bottom: 16px;
  }

  &__tooltip {
    width: 100%;
    margin-bottom: 16px;
  }

  &__select {
    width: 100%;
  }
}

.headline {
  display: flex;
  align-items: center;

  & > *:not(:last-child) {
    margin-right: 8px;
  }

  &:hover {
    .headline__control {
      opacity: 1 !important;
    }
  }

  &__control {
    padding: 0 !important;
    width: 12px;
    height: 12px;
    opacity: 0;
  }
}
</style>
