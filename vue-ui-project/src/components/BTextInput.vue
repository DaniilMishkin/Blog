<template>
  <div class="text-input-wrapper">
    <input
      class="text-input"
      :type="type"
      :placeholder="placeholder"
      v-bind:value="value"
      v-on:input="$emit('input', $event.target.value)"
    />
    <template v-if="validationProp.$dirty">
      <div v-for="message in validationMessages" :key="message" class="error">
        {{ message }}
      </div>
    </template>
  </div>
</template>

<script>
export default {
  name: "BTextInput",
  props: {
    type: {
      type: String,
      default: "text",
    },
    placeholder: {
      type: String,
      default: "",
    },
    value: {
      type: String,
      default: "",
    },
    validationProp: {
      type: Object,
    },
  },
  computed: {
    validationMessages() {
      let acc = [];

      if (
        !this.validationProp.required &&
        Object.prototype.hasOwnProperty.call(this.validationProp, "required")
      ) {
        acc.push(`${this.placeholder} required!`);
      }

      if (
        !this.validationProp.minLength &&
        Object.prototype.hasOwnProperty.call(this.validationProp, "minLength")
      ) {
        acc.push(
          `Min count of letters is ${this.validationProp.$params.minLength?.min}`
        );
      }

      if (
        !this.validationProp.maxLength &&
        Object.prototype.hasOwnProperty.call(this.validationProp, "maxLength")
      ) {
        acc.push(
          `Max count of letters is ${this.validationProp.$params.maxLength?.max}`
        );
      }

      if (
        !this.validationProp.email &&
        Object.prototype.hasOwnProperty.call(this.validationProp, "email")
      ) {
        acc.push("Must be email address!");
      }

      if (
        !this.validationProp.sameAs &&
        Object.prototype.hasOwnProperty.call(this.validationProp, "sameAs")
      ) {
        acc.push("Must be identical!");
      }

      return acc;
    },
  },
};
</script>

<style scoped lang="sass">
@import "@/assets/styles/elements/text-input.sass"
</style>
