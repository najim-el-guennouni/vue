<template>
    <div class="form-group">
        <label
            :for="id"
            class="col-form-label"
        >
            {{ label }}
        </label>
        <input
            :id="id"
            :name="id"
            :type="type"
            :value="modelValue"
            :class="{
                'is-invalid': !isValid,
                'form-control': true,
            }"
            @input="$emit('update:modelValue', $event.target.value)"
            @blur="$emit('blur', $event)"
        >
        <span
            v-show="!isValid"
            class="invalid-feedback"
        >
            {{ errorMessage }}
        </span>
    </div>
</template>

<script>
import { computed } from 'vue';

export default {
    name: 'FormInput',
    props: {
        id: {
            type: String,
            required: true,
        },
        label: {
            type: String,
            required: true,
        },
        errorMessage: {
            type: String,
            default: '',
        },
        type: {
            type: String,
            default: 'text',
        },
        modelValue: {
            type: String,
            default: '',
        },
    },
    emits: ['update:modelValue', 'blur'],
    setup(props) {
        const isValid = computed(() => !props.errorMessage);

        return {
            isValid,
        };
    },
};
</script>
