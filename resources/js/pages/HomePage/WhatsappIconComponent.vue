<template>
  <div class="whatsapp-icon">
    <!-- <img src="{{ asset('uploads/settings/general/whatsapp-logo.png') }}" alt="user-img"> -->
    <a
      href="https://api.whatsapp.com/send?phone=16465123391&text=Hi ebelong! Is any body available here?"
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
