<template>
    <div class="flex items-center mr-8">
        <button v-for="(color, theme) in themes" :key="theme"
        class="rounded-full w-4 h-4 mr-2 focus:outline-none"
        :class="{ 'border-2 border-blue-800': selectedTheme == theme}" 
        :style="{ backgroundColor: color}"
        @click="selectedTheme=theme">
        </button>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        created(){
            console.log('Component created');
            this.selectedTheme = localStorage.getItem('theme') || 'theme-light';
        },
        data() {
            return {
                themes: {
                    'theme-light': 'grey-light',
                    'theme-dark': 'black'
                },
                selectedTheme: 'theme-light'
            }
        },
        watch: {
            selectedTheme() { // watch any chances on 'selectedTheme' state
                document.body.className = document.body.className.replace(/theme-\w+/,this.selectedTheme);

                localStorage.setItem('theme', this.selectedTheme);
            }
        } 
    }
</script>
