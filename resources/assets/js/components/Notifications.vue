<template lang="html">
  <li class="notification-trigger" @click = "active = !active">
    <a class="icon ion-md-notifications-outline" :data-notifications="notifications.length"></a>
    <div class="notifications container" :class="{'active':active}">
      <div class="container-header">
        <h1 class="typ s">Notifications</h1>
        <div class="container-header-actions">
          <a class="txt icon ion-md-close-circle"></a>
        </div>
      </div>
      <div class="container-content">
        <!-- notifications -->
        <div class="notification-wrap" v-if="notifications.length" v-for="(notification,index) in notifications">
          <a class="notification" :class="{'read':notification.read}">
            <span class="typ n content">{{notification.content}}</span>
            <span class="typ s it time">{{notification.timing}}</span>
          </a>
        </div>

        <!-- no notifications-->
        <div class="align no-notifications" v-else>
          <h1 class="typ c s">No new notifications</h1>
        </div>
      </div>

    </div>
  </li>
</template>

<script>
export default {
  name: 'Notifications',
  data(){
    return {
      active: false,
      notifications:[
        {
          read: false,
          timing: '2 days ago',
          content: 'I said something about you'
        },
        {
          read: true,
          timing: '2 days ago',
          content: 'I said something about you'
        }
      ]
    }
  },
  mounted(){

  }
}
</script>

<style lang="css">
</style>
