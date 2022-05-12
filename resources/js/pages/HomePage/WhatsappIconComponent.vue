<template>
  <div class="whatsapp-icon">
    <!-- <img src="{{ asset('uploads/settings/general/whatsapp-logo.png') }}" alt="user-img"> -->
    <a
      href="https://www.freepnglogos.com/pics/whatsapp-logo-png"
      target="_blank"
      title="whatsapp icon"
    >
      <img
        :src="`/uploads/settings/general/whatsapp-logo.png`"
        alt="whatsapp"
      />
    </a>
  </div>
</template>
<!-- v-if="i < 4 && item.is_featured" -->
<script>
export default {
  name: "WhatsappIconComponent",
};
</script>
