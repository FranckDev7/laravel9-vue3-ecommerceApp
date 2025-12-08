<template>
    <button
        :class="[
            'w-full rounded-lg transition flex justify-center items-center gap-2',
            sizeClass,
            colorClass,
            iconPositionClass
        ]"
        @click="handleClick"
    >
        <!-- Icône LEFT -->
        <span
            v-if="icon && iconPosition === 'left'"
            :class="['material-symbols-outlined', iconSizeClass]"
        >
            {{ icon }}
        </span>

        <!-- Texte -->
        <span v-if="text">{{ text }}</span>

        <!-- Slot -->
        <slot v-else />

        <!-- Icône RIGHT -->
        <span
            v-if="icon && iconPosition === 'right'"
            :class="['material-symbols-outlined', iconSizeClass]"
        >
            {{ icon }}
        </span>
    </button>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
    color: { type: String, default: 'primary' },
    icon: { type: String, default: null },
    text: { type: String, default: null },
    size: { type: String, default: 'md' }, // sm, md, lg
    iconPosition: { type: String, default: 'left' }, // left, right
    iconSize: { type: String, default: 'md' }, // sm, md, lg
    onClick: { type: Function, default: null } // ✅ prop fonction
})

const emit = defineEmits(['click'])

// Méthode interne pour gérer le click
const handleClick = (event) => {
    // 1️⃣ Si le parent a passé une prop onClick
    if (props.onClick) props.onClick(event)

    // 2️⃣ On émet aussi l’événement click pour plus de flexibilité
    emit('click', event)
}

/* ---- Couleurs ---- */
const colorClass = computed(() => {
    switch (props.color) {
        case 'dark': return 'bg-gray-900 text-white hover:bg-gray-700'
        case 'danger': return 'bg-red-600 text-white hover:bg-red-500'
        case 'success': return 'bg-green-600 text-white hover:bg-green-500'
        case 'warning': return 'bg-yellow-500 text-white hover:bg-yellow-400'
        case 'info': return 'bg-cyan-600 text-white hover:bg-cyan-500'
        case 'primary':
        default: return 'bg-blue-600 text-white hover:bg-blue-500'
    }
})

/* ---- Taille du bouton ---- */
const sizeClass = computed(() => {
    switch (props.size) {
        case 'sm': return 'text-xs px-3 py-1'
        case 'lg': return 'text-lg px-6 py-3'
        case 'md':
        default: return 'text-sm px-4 py-2'
    }
})

/* ---- Position de l’icône ---- */
const iconPositionClass = computed(() => {
    return props.iconPosition === 'right' ? 'flex-row-reverse' : 'flex-row'
})

/* ---- Taille de l’icône ---- */
const iconSizeClass = computed(() => {
    switch (props.iconSize) {
        case 'sm': return 'text-base'
        case 'lg': return 'text-2xl'
        case 'md':
        default: return 'text-xl'
    }
})
</script>
