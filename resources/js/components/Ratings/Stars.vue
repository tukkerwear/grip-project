<template>
    <div>
        <ul class="icon-bar list-inline m-0" @mouseleave="stars=initialStars">
            <li class="list-inline-item" v-for="star in 5" @click="updateStars(star)">
                <i v-bind:class="[stars >= star ? 'fas' : 'far']"
                   @mouseover="stars=star"
                   class="far fa-star"
                ></i>

            </li>
            <li class="list-inline-item" v-show="initialStars > 0" @click="deleteStars()">
                <i class="fas fa-ban text-danger"></i>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: ['initialStars'],
        data: function () {
            return {
                stars: 0
            }
        },
        mounted() {
            this.stars = this.initialStars;
        },
        methods: {
            updateStars: function (rating) {
                this.$emit('updated-rating', rating);
            },
            deleteStars: function() {
                this.$emit('deleted-rating');
            }
        }
    }
</script>
