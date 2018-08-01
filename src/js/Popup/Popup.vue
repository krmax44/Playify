<template>
  <Page title="Settings">
    <ServiceSelector :services="services" @serviceChanged="saveSettings"></ServiceSelector>
    <Grid>
      <Column width="*">
        <Button href="https://krmax44.de/donate" target="_blank"><Icon icon="paypal"></Icon> Donate</Button>
      </Column>
      <Column width="*">
        <Button href="https://github.com/krmax44/Playify" target="_blank"><Icon icon="github"></Icon> Contribute</Button>
      </Column>
    </Grid>
  </Page>
</template>

<script>
import Settings from '../Settings';
import components from '../Components';
import ServiceSelector from './Components/ServiceSelector.vue';

export default {
  name: 'app',
  data () {
    return {
      services: Settings.services.map(service => {
        service.active = false; // add active property
        return service;
      })
    }
  },
  created() {
    let that = this;
    Settings
      .get()
      .then(settings => {
        let service = that.services.find(service => service.id === settings.service.id);
        service.active = true;
      });
  },
  methods: {
	  saveSettings (id) {
      const service = Settings.services.find(service => service.id === id);
      Settings.set({ service });
      this.services = this.services.map(s => {
        s.active = s.id === id;
        return s;
      });
	  }
  },
  components: Object.assign(components, { ServiceSelector })
}
</script>

<style lang="scss">
body {
  min-width: 460px;
  background-image: url('../../img/concert-3.jpg');
}

*, *::before, *::after {
  user-select: none;
}
</style>