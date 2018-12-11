<div class="sidebar">
  <el-menu>
    <el-submenu index="1">
      <template slot="title"><i class="el-icon-tickets"></i>Tahrirlash</template>
      <el-menu-item-group>
        <template slot="title">Kirim</template>
        <el-menu-item index="1-1">
          <router-link :to="{ name: 'editStaple' }" exact active-class="active">
            Tola
          </router-link>
        </el-menu-item>
        <el-menu-item index="1-2">
          <router-link :to="{ name: 'editCorn' }" exact active-class="active">
            Texnik chigit
          </router-link>
        </el-menu-item>
        <el-menu-item index="1-3">
          <router-link :to="{ name: 'editCotton' }" exact active-class="active">
            Paxta momig'i
          </router-link>
        </el-menu-item>
        <el-menu-item index="1-4">
          <router-link :to="{ name: 'editOther' }" exact active-class="active">
            Boshqalar
          </router-link>
        </el-menu-item>
      </el-menu-item-group>
      <el-menu-item-group title="Chiqim">
        <el-menu-item index="1-5">
          <router-link :to="{ name: 'addReport' }" exact active-class="active">
            Hisobot
          </router-link>
        </el-menu-item>
      </el-menu-item-group>
    </el-submenu>
    <el-submenu index="2">
      <template slot="title"><i class="el-icon-menu"></i>Statistika</template>
      <el-menu-item-group>
        <template slot="title">Kirim</template>
        <el-menu-item index="2-1">
          <router-link :to="{ name: 'statStaple' }" exact active-class="active">
            Tola
          </router-link>
        </el-menu-item>
        <el-menu-item index="2-2">
          <router-link :to="{ name: 'statCorn' }" exact active-class="active">
            Texnik chigit
          </router-link>
        </el-menu-item>
        <el-menu-item index="2-3">
          <router-link :to="{ name: 'statCotton' }" exact active-class="active">
            Paxta momig'i
          </router-link>
        </el-menu-item>
        <el-menu-item index="2-4">
          <router-link :to="{ name: 'statOther' }" exact active-class="active">
            Boshqalar
          </router-link>
        </el-menu-item>
      </el-menu-item-group>
      <el-menu-item-group title="Chiqim">
        <el-menu-item index="2-5">
          <router-link :to="{ name: 'statCharges' }" exact active-class="active">
            Hisobot
          </router-link>
        </el-menu-item>
      </el-menu-item-group>
    </el-submenu>
    <el-submenu index="3">
      <template slot="title"><i class="el-icon-menu"></i>Sozlamalar</template>
      <el-menu-item-group>
        <el-menu-item index="3-1">
          <router-link :to="{ name: 'optFactory' }" exact active-class="active">
            Korxonalar
          </router-link>
        </el-menu-item>
        <el-menu-item index="3-2">
          <router-link :to="{ name: 'optCurrency' }" exact active-class="active">
            Valyutalar
          </router-link>
        </el-menu-item>
        <el-menu-item index="3-3">
          <router-link :to="{ name: 'optCharges' }" exact active-class="active">
            Chiqim turlari
          </router-link>
        </el-menu-item>
        <el-menu-item index="3-4">
          <router-link :to="{ name: 'optDislocation' }" exact active-class="active">
            Chigit oylik dislokatsiyasi
          </router-link>
        </el-menu-item>
      </el-menu-item-group>
    </el-submenu>
  </el-menu>
</div>