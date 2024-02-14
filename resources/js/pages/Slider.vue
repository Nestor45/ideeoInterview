<template>
    <v-carousel v-if="images.length > 0"  cycle height="400"  hide-delimiter-background show-arrows="hover">
        <v-carousel-item v-for="(image,i) in images" :key="image.id">
            <v-row>
                <v-col>
                    <v-carousel-item-title>{{ image.author }}</v-carousel-item-title>
                </v-col>
                <v-col>
                    <v-carousel-item-subtitle>
                     <a :href="image.url" target="_blank">Ver más</a>
                    </v-carousel-item-subtitle>
                </v-col>
            </v-row>
            <v-btn @click="downloadImage(image.download_url)" color="primary" class="text-center">Descargar</v-btn>
            <v-img :src="image.download_url" :alt="image.author" />
        </v-carousel-item>
    </v-carousel>
    <div v-else>
      <p>No hay imágenes disponibles.</p>
    </div>
</template>

<script>
export default {
  data() {
    return {
      images: [],
    };
  },
  mounted() {
    this.fetchImages();
  },
  methods: {
    async fetchImages() {
      try {
        const response = await this.$axios.get('https://picsum.photos/v2/list');
        this.images = response.data;
      } catch (error) {
        console.error('Error fetching images:', error);
      }
    },
  },
};
</script>