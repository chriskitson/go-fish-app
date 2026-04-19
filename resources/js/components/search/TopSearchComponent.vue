<template>
  <div class="flex items-center mx-4">
    <div
      class="flex flex-row flex-wrap items-center w-full text-sm md:h-12"
    >
      <div
        class="flex items-center w-full h-12 px-2 mb-2 bg-white border-grey-200 md:border-t md:border-b md:border-l md:mb-0 md:rounded-tl-lg md:rounded-bl-lg md:w-56"
      >
        <client-only>
          <date-picker
            :value="date"
            type="date"
            :clearable="false"
            :disabled-date="disableDate"
            v-on:change="$emit('change', $event)"
            class="w-full top-date-picker"
            format="DD MMM YYYY"
          ></date-picker>
        </client-only>
      </div>
      <div
        class="relative flex items-center w-full h-12 px-2 mb-2 bg-white border-grey-200 md:border-t md:border-b md:border-l md:w-96 md:mb-0"
      >
        <span class="mr-2 text-grey-400">
          <icon name="location-marker" class="w-6 h-6" />
        </span>
        <input
          v-model="query"
          @input="onInput"
          @focus="showDropdown = true"
          @blur="onBlur"
          type="search"
          placeholder="Search by venue name or location"
          class="w-full px-4 py-2 bg-transparent outline-none rounded-md"
        />

        <!-- Dropdown -->
        <div 
          v-if="showDropdown && (results.length > 0 || isLoading)"
          class="absolute left-0 z-50 w-full mt-1 overflow-y-auto bg-white border rounded-lg shadow-xl top-full max-h-80 border-grey-200"
        >
          <div v-if="isLoading" class="p-4 text-sm text-center text-grey-500">
            <svg class="w-5 h-5 mx-auto text-orange-200 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
          </div>
          <ul v-else>
            <li 
              v-for="(item, i) in results" 
              :key="i"
              @mousedown="selectResult(item)"
              class="flex items-center px-4 py-3 transition duration-150 ease-in-out cursor-pointer hover:bg-orange-50 group"
            >
              <div class="flex-shrink-0 mr-3">
                <svg v-if="item.type === 'venue'" class="w-5 h-5 text-orange-200 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M12.98,3.52C17.08,4.06 20.14,7.02 22.38,10.3C23.08,11.32 23.08,12.67 22.38,13.69C20.14,16.97 17.08,19.93 12.98,20.47C11.06,20.72 9.14,20.21 7.39,19.18L4,20.88V17C2.61,15.95 1.74,14.38 1.38,12.68C1.38,12.32 1.38,11.66 1.38,11.3C1.74,9.6 2.61,8.03 4,6.97V3.09L7.39,4.8C9.14,3.76 11.06,3.25 12.98,3.52M15,10A1.5,1.5 0 0,0 13.5,11.5A1.5,1.5 0 0,0 15,13A1.5,1.5 0 0,0 16.5,11.5A1.5,1.5 0 0,0 15,10Z" />
                </svg>
                <icon v-else-if="item.type === 'category'" name="globe" class="w-5 h-5 text-orange-200 group-hover:text-orange-300" />
                <icon v-else name="location-marker" class="w-5 h-5 text-grey-400 group-hover:text-orange-200" />
              </div>
              <div class="flex-1 truncate">
                <div class="font-medium text-grey-800 truncate">
                  {{ item.title }} 
                  <span v-if="item.type === 'venue'" class="inline-block px-1.5 py-0.5 ml-2 text-[10px] font-bold tracking-wider text-white uppercase bg-orange-200 rounded shrink-0">Fishery</span>
                  <span v-if="item.type === 'category'" class="inline-block px-1.5 py-0.5 ml-2 text-[10px] font-bold tracking-wider text-white uppercase bg-blue-400 rounded shrink-0">{{ item.subtitle }}</span>
                </div>
                <div v-if="item.type !== 'category'" class="text-xs text-grey-500 truncate">{{ item.subtitle }}</div>
              </div>
            </li>
          </ul>
        </div>
      </div>
      <div
        class="flex items-center w-full h-12 px-2 mb-2 bg-white border-grey-200 md:border-t md:border-b md:border-l md:w-48 md:mb-0"
      >
        <span class="mr-2 text-grey-400 whitespace-nowrap">Filter:</span>
        <select
          v-model="selectedType"
          class="w-full bg-transparent outline-none text-sm"
        >
          <option v-for="type in types" :key="type" :value="type">
            {{ type }}
          </option>
        </select>
      </div>
      <button
        class="w-full h-12 px-8 text-white transition duration-150 ease-in-out bg-orange-200 border border-orange-200 rounded-lg md:w-auto disabled:opacity-50 hover:bg-opacity-90"
        :disabled="!venueSearch.valid"
        @click="triggerSearch"
      >
        Search
      </button>
    </div>
  </div>
</template>

<script>
import ClientOnly from "vue-client-only";
import DatePicker from "vue2-datepicker";
import { getDay } from "../../utils";
import axios from "axios";
import debounce from "lodash/debounce";

export default {
  props: ["venueSearch", "date"],
  components: {
    ClientOnly,
    DatePicker,
  },
  data() {
    return {
      getDay,
      query: "",
      showDropdown: false,
      isLoading: false,
      results: [],
      selectedItem: null,
      autocompleteService: null,
      types: [
        "All",
        "Rainbow Trout",
        "Brown Trout",
        "Sea Trout",
        "Salmon",
        "Coarse",
        "Pike",
        "Carp",
      ],
    };
  },
  computed: {
    selectedType: {
      get() {
        return this.venueSearch.type;
      },
      set(val) {
        this.$store.dispatch("VENUE_SEARCH_TYPE_SET", val);
      },
    },
  },
  mounted() {
    if (this.venueSearch && this.venueSearch.search) {
      this.query = this.venueSearch.search;
    }
  },
  methods: {
    disableDate(date) {
      const midnight = new Date();
      midnight.setHours(0, 0, 0, 0);
      return date < midnight;
    },
    onBlur() {
      // Delay allows the click event on the dropdown item to execute
      setTimeout(() => {
        this.showDropdown = false;
      }, 200);
    },
    onInput: debounce(async function() {
      if (!this.query.trim()) {
        this.results = [];
        this.isLoading = false;
        return;
      }
      
      this.isLoading = true;
      this.selectedItem = null;
      this.$emit('set', null); // clear existing valid search state since they are typing

      const localResults = [];
      const googleResults = [];

      // 1. Fetch Local Venues
      try {
        const { data } = await axios.get('/api/venues/autocomplete', {
          params: { q: this.query }
        });
        localResults.push(...data);
      } catch (err) {
        console.error("Local search error", err);
      }

      // 2. Fetch Google Places
      if (window.google && window.google.maps && window.google.maps.places) {
        if (!this.autocompleteService) {
          this.autocompleteService = new window.google.maps.places.AutocompleteService();
        }
        try {
          const predictions = await new Promise((resolve) => {
            this.autocompleteService.getPlacePredictions(
              { input: this.query, componentRestrictions: { country: ["GB", "IE"] } }, 
              (predictions, status) => {
                if (status === window.google.maps.places.PlacesServiceStatus.OK && predictions) {
                  resolve(predictions);
                } else {
                  resolve([]);
                }
              }
            );
          });
          
          predictions.forEach(p => {
            googleResults.push({
              type: 'place',
              title: p.structured_formatting.main_text,
              subtitle: p.structured_formatting.secondary_text,
              data: p // This contains place_id
            });
          });
        } catch(err) {}
      }

      // Merge: Venues first, then Places
      this.results = [...localResults, ...googleResults];
      this.isLoading = false;
    }, 300),

    selectResult(item) {
      this.query = item.title;
      this.selectedItem = item;
      this.showDropdown = false;

      if (item.type === 'place') {
        if (window.google && window.google.maps) {
           const map = new window.google.maps.Map(document.createElement('div'));
           const placesService = new window.google.maps.places.PlacesService(map);
           placesService.getDetails({ placeId: item.data.place_id, fields: ['place_id', 'formatted_address', 'address_components', 'geometry'] }, (place, status) => {
              if (status === window.google.maps.places.PlacesServiceStatus.OK) {
                 this.$emit('set', place);
              }
           });
        }
      } else if (item.type === 'category') {
        window.location.href = `/category/${item.data.id}`;
      } else {
        // Instantly navigate to the fishery page with date if available!
        if (this.date) {
            window.location.href = `/venue/${item.data.id}/${this.date.getTime()}`;
        } else {
            window.location.href = `/venue/${item.data.id}`;
        }
      }
    },

    triggerSearch() {
      if (this.selectedItem && this.selectedItem.type === 'venue') {
         window.location.href = `/venue/${this.selectedItem.data.id}`;
      } else if (this.selectedItem && this.selectedItem.type === 'category') {
         window.location.href = `/category/${this.selectedItem.data.id}`;
      } else {
         this.$emit('search', this.selectedType);
      }
    }
  }
};
</script>
