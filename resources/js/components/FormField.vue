<template>
  <div>
    <component
        :is="`form-${field.field.component}`"
        ref="field"
        :resource-id="resourceId"
        :resource-name="resourceName"
        :via-resource="viaResource"
        :via-resource-id="viaResourceId"
        :via-relationship="viaRelationship"
        :field="field.field"
        :errors="errors"
        style="border-bottom: none"
    />

    <div class="flex border-b border-40 pb-6" style="margin-top: -1.5rem;">
      <div class="w-1/5"></div>
      <div class="w-1/2 px-8">
        <button
            class="btn btn-default btn-primary"
            style="top: 1.5rem; left: 70%"
            @click.prevent="showModal = true"
        >{{ __('Scan') }}
        </button>
      </div>
    </div>

    <camera-capture-modal
        v-if="showModal"
        :display-width="field.displayWidth"
        :show-submit="field.canSubmit"
        @close="showModal = false"
        @decoded="scanData"
    />
  </div>
</template>

<script>
import CameraCaptureModal from "./CameraCaptureModal"
import {FormField, HandlesValidationErrors} from 'laravel-nova'

export default {
  components: {CameraCaptureModal},

  mixins: [FormField, HandlesValidationErrors],

  props: ['resourceName', 'resourceId', 'field'],

  data() {
    return {
      showModal: false,
    }
  },

  methods: {
    scanData(decodedString) {
      this.showModal = false

      Nova.$emit(this.field.field.attribute + '-value', decodedString)
    },

    /**
     * Fill the given FormData object with the field's internal value.
     */
    fill(formData) {
      this.$refs.field.fill(formData)
    },
  },
}
</script>
