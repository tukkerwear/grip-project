<template>
    <div class="card">
        <img v-bind:src="serie.posters[0].url" alt="Poster" class="card-img-top card-img-serie">
        <div class="card-body">
            <h2 class="card-title h3" v-text="serie.title"></h2>

            <p v-text="serie.plot"></p>
        </div>
        <div class="card-footer bg-white">
            <a href="#" class="btn btn-sm btn-primary">
                <i class="fas fa-plus" title="Add to watchlist"></i> Watchlist
            </a>
        </div>

        <div class="card-footer">
            <div class="row">
                <div class="col">
                    <stars :initial-stars="stars" v-on:updated-rating="handleUpdatedRating"></stars>
                </div>
                <div class="col">
                    <ul class="icon-bar list-inline m-0 float-right">
                        <li class="list-inline-item">
                            <i class="far fa-heart" title="Favourite"></i>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            serie: Object
        },
        data: function () {
            return {
                stars: this.serie.rating.rating,
            }
        },
        methods: {
            handleUpdatedRating: function (rating) {
                this.stars = rating;

                axios
                    .patch(`/api/series/${this.serie.id}/ratings`, {
                        rating: rating
                    })
                    .then((response) => {
                        this.$notify({
                            group: 'notifications',
                            title: 'Rating has been updated',
                            text: `You have given <strong>${this.serie.title}</strong> ${rating} star(s)`,
                            type: 'success'
                        });
                    })
                    .catch((error) => {
                        this.$notify({
                            group: 'notifications',
                            title: 'Ooh noo!',
                            text: `Something went wrong while updating the rating of <strong>${this.serie.title}</strong> :(`,
                            type: 'error'
                        });
                    });
            }
        }
    }
</script>
