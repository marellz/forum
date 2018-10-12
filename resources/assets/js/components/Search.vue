<template lang="html">
  <div class="search">
    <div class="bar-holder non-mobile-only">
      <form :class="{'active':activeSearchModal}">
        <div class="input search">
          <input type="search" placeholder="Search threads.." v-model="q" @focus="activeSearchModal = true" @blue="activeSearchModal = false"/>
        </div>
      </form>
    </div>
    <div class="mobile-only">
      <div class="search-content modal" :class="{'is-active':activeSearchModal}">
        <div class="modal-control">
          <button class="close s" @click="activeSearchModal = false"></button>
        </div>
        <div class="modal-content">
          <div class="input -c pd-s">
            <input v-model="q" placeholder="Search anything"/>
          </div>

          <div class="search-results" v-if="!results.length">
            <div class="pd">
              <h1 class="typ c">No results.</h1>
            </div>
          </div>
        </div>
      </div>
      <div class="menu flat">
        <ul>
          <li>
            <a class="icon ion-md-search" @click="activeSearchModal=true"></a>
          </li>
        </ul>

      </div>
    </div>
  </div>

</template>

<script>
export default {
  name:'Search',
  data(){
    return {
      activeSearchModal: false,
      q: '',
      results:[],
    }
  }
}
</script>

<style lang="css">
</style>
