<!-- Edit -->
<template id="edit-staple">
  <div>
    <el-collapse>
      <el-collapse-item title="Tola uchun hisobot qo'shish" name="1">
        <el-form label-position="top" id="form" :model="formData" ref="form">
          <el-row :gutter="20">
            <el-col :span="8">
              <el-form-item
                prop="factory_id"
                name="factory_id"
                label="Korxona nomi"
                :rules="[
                  { required: true, message: 'Korxona nomini tanlang', trigger: 'submit' },
                ]"
              >
                <el-select v-model="formData.factory_id">
                  <el-option
                    v-for="item in factories"
                    :key="item.id"
                    :label="item.name"
                    :value="item.id">
                  </el-option>
                </el-select>
              </el-form-item>
            </el-col>
            <el-col :span="8">
              <el-form-item
                prop="currency_id"
                name="currency_id"
                label="Valyuta"
                :rules="[
                  { required: true, message: 'Valyutani tanlang', trigger: 'submit' },
                ]"
              >
                <el-select v-model="formData.currency_id">
                  <el-option
                    v-for="item in currencies"
                    :key="item.id"
                    :label="item.name"
                    :value="item.id">
                  </el-option>
                </el-select>
              </el-form-item>
            </el-col>
            <el-col :span="8">
              <el-form-item
                name="date"
                prop="date"
                label="Jo'natilgan sana"
                :rules="[
                  { required: true, message: 'Jo\'natilgan sanani kiriting', trigger: 'submit' },
                ]"
              >
                <el-date-picker :value-format="'yyyy-MM-dd'" :editable="false" type="date" v-model="formData.date"></el-date-picker>
              </el-form-item>
            </el-col>
            <el-col :span="12">
              <el-form-item
                name="weight"
                prop="weight"
                label="Jo'natilgan paxta og'irligi"
                :rules="[
                  { required: true, message: 'Jo\'natilgan paxta tolasi og\'irligini kiriting', trigger: 'submit' },
                ]"
              >
                <el-input v-model="formData.weight"></el-input>
              </el-form-item>
            </el-col>
            <el-col :span="12">
              <el-form-item
                name="summ"
                prop="summ"
                label="Jo'natilgan paxta uchun to'lov qiymati"
                :rules="[
                  { required: true, message: 'Jo\'natilgan paxta tolasi to\'lov qiymatini kiriting', trigger: 'submit' },
                ]"
              >
                <el-input v-model="formData.summ"></el-input>
              </el-form-item>
            </el-col>
            <el-col :span="8">
              <el-form-item
                name="by_bank"
                prop="by_bank"
                label="Bank orqali tushgan mablag'"
              >
                <el-input v-model="formData.by_bank"></el-input>
              </el-form-item>
            </el-col>
            <el-col :span="8">
              <el-form-item
                name="by_tax"
                prop="by_tax"
                label="Majburiy ijro orqali to'langan mablag'"
              >
                <el-input v-model="formData.by_tax"></el-input>
              </el-form-item>
            </el-col>
            <el-col :span="8">
              <el-form-item
                name="by_self_counting"
                prop="by_self_counting"
                label="O'zaro hisob-kitob orqali tushgan mablag'"
              >
                <el-input v-model="formData.by_self_counting"></el-input>
              </el-form-item>
            </el-col>
          </el-row>
          <el-form-item>
            <el-button type="primary" @click="submitForm('form')">Qo'shish</el-button>
          </el-form-item>
        </el-form>
      </el-collapse-item>
    </el-collapse>
    <div class="filter">
        <el-row :gutter="10">
          <el-col :span="6">
            <el-select clearable v-model="filter.factory_id" placeholder="Korxona nomi">
              <el-option
                v-for="item in factories"
                :key="item.id"
                :label="item.name"
                :value="item.id">
              </el-option>
            </el-select>
          </el-col>
          <el-col :span="8">
            <el-date-picker style="width: 100%" :picker-options="option" type="month" :value-format="'yyyy-MM-dd'" :editable="false" type="date" v-model="filter.start"></el-date-picker>
          </el-col>
          <el-col :span="8">
            <el-date-picker style="width: 100%" :picker-options="option" type="month" :value-format="'yyyy-MM-dd'" :editable="false" type="date" v-model="filter.end"></el-date-picker>
          </el-col>
          <el-col :span="2">
            <el-button @click="pageChange(1)" type="primary"><i class="fa fa-check" aria-hidden="true"></i></el-button>
          </el-col>
      </el-row>
    </div>
    <div v-if="post&&post.length>0">
      <el-table
        v-loading="loading"
        element-loading-text="Yuklanmoqda..."
        element-loading-spinner="el-icon-loading"
        element-loading-background="rgba(0, 0, 0, 0.8)"
        :data="post"
        style="width: 100%">
        <el-table-column
          type="index"
          :index="(index) => index + 1"
          width="50">
        </el-table-column>
        <el-table-column
          width="100"
          label="Nomi">
          <template slot-scope="scope">
            {{ scope.row.name }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="Oy/bosh deb qarzi">
          <template slot-scope="scope">
            {{ (scope.row.before_deb > 0) ? scope.row.before_deb : 0 }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="Oy/bosh deb haqqi">
          <template slot-scope="scope">
            {{ (scope.row.before_deb < 0) ? -scope.row.before_deb : 0 }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="Jo'n/paxta tolasi og'irligi">
          <template slot-scope="scope">
            {{ scope.row.weight }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="Jo'n/paxta narxi">
          <template slot-scope="scope">
            {{ scope.row.summ }}
          </template>
        </el-table-column>
        <el-table-column
          width="100"
          label="Valyuta nomi">
          <template slot-scope="scope">
            {{ getCurrency(scope.row.currency_id) }}
          </template>
        </el-table-column>
        <el-table-column
          label="Umumiy to'langan summa">
          <template slot-scope="scope">
            {{ scope.row.pay_summ }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="Bank orqali to'langan">
          <template slot-scope="scope">
            {{ scope.row.by_bank }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="Majburiy undirish orqali to'langan">
          <template slot-scope="scope">
            {{ scope.row.by_tax }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="O'zaro hisob-kitob">
          <template slot-scope="scope">
            {{ scope.row.by_self_counting }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="Joriy vaqtdagi qarzi">
          <template slot-scope="scope">
            {{ (scope.row.current_deb > 0) ? scope.row.current_deb : 0 }}
          </template>
        </el-table-column>
        <el-table-column
          width="120"
          label="Joriy vaqtdagi haqqi">
          <template slot-scope="scope">
            {{ (scope.row.current_deb < 0) ? -scope.row.current_deb : 0 }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="To'lov sanasi">
          <template slot-scope="scope">
            {{ scope.row.date | moment('DD/MM/YYYY') }}
          </template>
        </el-table-column>
        <el-table-column
          width="70"
          fixed="right"
          align="center">
          <template slot-scope="scope">
            <el-button
              size="mini"
              @click="editPost(scope.row.id)"><i class="fa fa-pencil" aria-hidden="true"></i></el-button>
          </template>
        </el-table-column>
        <el-table-column
          width="60"
          fixed="right"
          align="right">
          <template slot-scope="scope">
            <el-button
              size="mini"
              type="danger"
              @click="deletePost(scope.row.id)"><i class="fa fa-trash" aria-hidden="true"></i></el-button>
          </template>
        </el-table-column>
      </el-table>
      <el-pagination
        v-if="total > limit"
        class="post-pagination"
        background
        :page-size="limit"
        :current-page.sync="offset"
        @current-change="pageChange" 
        layout="prev, pager, next"
        :total="total">
      </el-pagination>
    </div>

    <el-dialog title="Tahrirlash" :visible.sync="edit.editDialogVisible">
      <el-form label-position="top" id="formEdit" :model="edit.data" ref="formEdit">
        <el-row :gutter="20">
          <el-col :span="8">
            <el-form-item
              prop="factory_id"
              name="factory_id"
              label="Korxona nomi"
              :rules="[
                { required: true, message: 'Korxona nomini tanlang', trigger: 'submit' },
              ]"
            >
              <el-select v-model="edit.data.factory_id">
                <el-option
                  v-for="item in factories"
                  :key="item.id"
                  :label="item.name"
                  :value="item.id">
                </el-option>
              </el-select>
            </el-form-item>
          </el-col>
          <el-col :span="8">
            <el-form-item
              prop="currency_id"
              name="currency_id"
              label="Valyuta"
              :rules="[
                { required: true, message: 'Valyutani tanlang', trigger: 'submit' },
              ]"
            >
              <el-select v-model="edit.data.currency_id">
                <el-option
                  v-for="item in currencies"
                  :key="item.id"
                  :label="item.name"
                  :value="item.id">
                </el-option>
              </el-select>
            </el-form-item>
          </el-col>
          <el-col :span="8">
            <el-form-item
              name="date"
              prop="date"
              label="Jo'natilgan sana"
              :rules="[
                { required: true, message: 'Jo\'natilgan sanani kiriting', trigger: 'submit' },
              ]"
            >
              <el-date-picker :value-format="'yyyy-MM-dd'" :editable="false" type="date" v-model="edit.data.date"></el-date-picker>
            </el-form-item>
          </el-col>
          <el-col :span="12">
            <el-form-item
              name="weight"
              prop="weight"
              label="Jo'natilgan paxta tolasi og'irligi"
              :rules="[
                { required: true, message: 'Jo\'natilgan paxta tolasi og\'irligini kiriting', trigger: 'submit' },
              ]"
            >
              <el-input v-model="edit.data.weight"></el-input>
            </el-form-item>
          </el-col>
          <el-col :span="12">
            <el-form-item
              name="summ"
              prop="summ"
              label="Jo'natilgan paxta uchun to'lov qiymati"
              :rules="[
                { required: true, message: 'Jo\'natilgan paxta tolasi to\'lov qiymatini kiriting', trigger: 'submit' },
              ]"
            >
              <el-input v-model="edit.data.summ"></el-input>
            </el-form-item>
          </el-col>
          <el-col :span="8">
            <el-form-item
              name="by_bank"
              prop="by_bank"
              label="Bank orqali tushgan mablag'"
            >
              <el-input v-model="edit.data.by_bank"></el-input>
            </el-form-item>
          </el-col>
          <el-col :span="8">
            <el-form-item
              name="by_tax"
              prop="by_tax"
              label="Majburiy ijro orqali to'langan mablag'"
            >
              <el-input v-model="edit.data.by_tax"></el-input>
            </el-form-item>
          </el-col>
          <el-col :span="8">
            <el-form-item
              name="by_self_counting"
              prop="by_self_counting"
              label="O'zaro hisob-kitob orqali tushgan mablag'"
            >
              <el-input v-model="edit.data.by_self_counting"></el-input>
            </el-form-item>
          </el-col>
        </el-row>
        <el-form-item>
          <el-button type="primary" @click="updatePost('formEdit')">Qo'shish</el-button>
        </el-form-item>
      </el-form>
    </el-dialog>

  </div>
</template>

<template id="edit-corn">
  <div>
    <el-collapse>
      <el-collapse-item title="Texnik chigit uchun hisobot qo'shish" name="1">
        <el-form label-position="top" id="form" :model="formData" ref="form">
          <el-row :gutter="20">
            <el-col :span="8">
              <el-form-item
                prop="factory_id"
                name="factory_id"
                label="Korxona nomi"
                :rules="[
                  { required: true, message: 'Korxona nomini tanlang', trigger: 'submit' },
                ]"
              >
                <el-select v-model="formData.factory_id">
                  <el-option
                    v-for="item in factories"
                    :key="item.id"
                    :label="item.name"
                    :value="item.id">
                  </el-option>
                </el-select>
              </el-form-item>
            </el-col>
            <el-col :span="8">
              <el-form-item
                prop="currency_id"
                name="currency_id"
                label="Valyuta"
                :rules="[
                  { required: true, message: 'Valyutani tanlang', trigger: 'submit' },
                ]"
              >
                <el-select v-model="formData.currency_id">
                  <el-option
                    v-for="item in currencies"
                    :key="item.id"
                    :label="item.name"
                    :value="item.id">
                  </el-option>
                </el-select>
              </el-form-item>
            </el-col>
            <el-col :span="8">
              <el-form-item
                name="date"
                prop="date"
                label="Jo'natilgan sana"
                :rules="[
                  { required: true, message: 'Jo\'natilgan sanani kiriting', trigger: 'submit' },
                ]"
              >
                <el-date-picker :value-format="'yyyy-MM-dd'" :editable="false" type="date" v-model="formData.date"></el-date-picker>
              </el-form-item>
            </el-col>
            <el-col :span="12">
              <el-form-item
                name="weight"
                prop="weight"
                label="Jo'natilgan texnik chigit og'irligi"
                :rules="[
                  { required: true, message: 'Jo\'natilgan texnik chigit og\'irligini kiriting', trigger: 'submit' },
                ]"
              >
                <el-input v-model="formData.weight"></el-input>
              </el-form-item>
            </el-col>
            <el-col :span="12">
              <el-form-item
                name="summ"
                prop="summ"
                label="Jo'natilgan texnik chigit uchun to'lov qiymati"
                :rules="[
                  { required: true, message: 'Jo\'natilgan texnik chigit to\'lov qiymatini kiriting', trigger: 'submit' },
                ]"
              >
                <el-input v-model="formData.summ"></el-input>
              </el-form-item>
            </el-col>
            <el-col :span="8">
              <el-form-item
                name="by_bank"
                prop="by_bank"
                label="Bank orqali tushgan mablag'"
              >
                <el-input v-model="formData.by_bank"></el-input>
              </el-form-item>
            </el-col>
            <el-col :span="8">
              <el-form-item
                name="by_tax"
                prop="by_tax"
                label="Majburiy ijro orqali to'langan mablag'"
              >
                <el-input v-model="formData.by_tax"></el-input>
              </el-form-item>
            </el-col>
            <el-col :span="8">
              <el-form-item
                name="by_self_counting"
                prop="by_self_counting"
                label="O'zaro hisob-kitob orqali tushgan mablag'"
              >
                <el-input v-model="formData.by_self_counting"></el-input>
              </el-form-item>
            </el-col>
          </el-row>
          <el-form-item>
            <el-button type="primary" @click="submitForm('form')">Qo'shish</el-button>
          </el-form-item>
        </el-form>
      </el-collapse-item>
    </el-collapse>
    <div class="filter">
        <el-row :gutter="10">
          <el-col :span="6">
            <el-select clearable v-model="filter.factory_id" placeholder="Korxona nomi">
              <el-option
                v-for="item in factories"
                :key="item.id"
                :label="item.name"
                :value="item.id">
              </el-option>
            </el-select>
          </el-col>
          <el-col :span="8">
            <el-date-picker style="width: 100%" :picker-options="option" type="month" :value-format="'yyyy-MM-dd'" :editable="false" type="date" v-model="filter.start"></el-date-picker>
          </el-col>
          <el-col :span="8">
            <el-date-picker style="width: 100%" :picker-options="option" type="month" :value-format="'yyyy-MM-dd'" :editable="false" type="date" v-model="filter.end"></el-date-picker>
          </el-col>
          <el-col :span="2">
            <el-button @click="pageChange(1)" type="primary"><i class="fa fa-check" aria-hidden="true"></i></el-button>
          </el-col>
      </el-row>
    </div>
    <div v-if="post&&post.length>0">
      <el-table
        v-loading="loading"
        element-loading-text="Yuklanmoqda..."
        element-loading-spinner="el-icon-loading"
        element-loading-background="rgba(0, 0, 0, 0.8)"
        :data="post"
        style="width: 100%">
        <el-table-column
          type="index"
          :index="(index) => index + 1"
          width="50">
        </el-table-column>
        <el-table-column
          width="100"
          label="Nomi">
          <template slot-scope="scope">
            {{ scope.row.name }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="Oy/bosh deb qarzi">
          <template slot-scope="scope">
            {{ (scope.row.before_deb > 0) ? scope.row.before_deb : 0 }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="Oy/bosh deb haqqi">
          <template slot-scope="scope">
            {{ (scope.row.before_deb < 0) ? -scope.row.before_deb : 0 }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="Tasdiqlangan dislokatsiya rejasi">
          <template slot-scope="scope">
            {{ (scope.row.corn_dislocation[0])?scope.row.corn_dislocation[0].weight:'Belgilanmagan' }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="Jo'n/texnik chigit og'irligi">
          <template slot-scope="scope">
            {{ scope.row.weight }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="Jo'n/texnik chigit narxi">
          <template slot-scope="scope">
            {{ scope.row.summ }}
          </template>
        </el-table-column>
        <el-table-column
          width="100"
          label="Valyuta nomi">
          <template slot-scope="scope">
            {{ getCurrency(scope.row.currency_id) }}
          </template>
        </el-table-column>
        <el-table-column
          label="Umumiy to'langan summa">
          <template slot-scope="scope">
            {{ scope.row.pay_summ }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="Bank orqali to'langan">
          <template slot-scope="scope">
            {{ scope.row.by_bank }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="Majburiy undirish orqali to'langan">
          <template slot-scope="scope">
            {{ scope.row.by_tax }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="O'zaro hisob-kitob">
          <template slot-scope="scope">
            {{ scope.row.by_self_counting }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="Joriy vaqtdagi qarzi">
          <template slot-scope="scope">
            {{ (scope.row.current_deb > 0) ? scope.row.current_deb : 0 }}
          </template>
        </el-table-column>
        <el-table-column
          width="120"
          label="Joriy vaqtdagi haqqi">
          <template slot-scope="scope">
            {{ (scope.row.current_deb < 0) ? -scope.row.current_deb : 0 }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="To'lov sanasi">
          <template slot-scope="scope">
            {{ scope.row.date | moment('DD/MM/YYYY') }}
          </template>
        </el-table-column>
        <el-table-column
          width="70"
          fixed="right"
          align="center">
          <template slot-scope="scope">
            <el-button
              size="mini"
              @click="editPost(scope.row.id)"><i class="fa fa-pencil" aria-hidden="true"></i></el-button>
          </template>
        </el-table-column>
        <el-table-column
          width="60"
          fixed="right"
          align="right">
          <template slot-scope="scope">
            <el-button
              size="mini"
              type="danger"
              @click="deletePost(scope.row.id)"><i class="fa fa-trash" aria-hidden="true"></i></el-button>
          </template>
        </el-table-column>
      </el-table>
      <el-pagination
        v-if="total > limit"
        class="post-pagination"
        background
        :page-size="limit"
        :current-page.sync="offset"
        @current-change="pageChange" 
        layout="prev, pager, next"
        :total="total">
      </el-pagination>
    </div>

    <el-dialog title="Tahrirlash" :visible.sync="edit.editDialogVisible">
      <el-form label-position="top" id="formEdit" :model="edit.data" ref="formEdit">
        <el-row :gutter="20">
          <el-col :span="8">
            <el-form-item
              prop="factory_id"
              name="factory_id"
              label="Korxona nomi"
              :rules="[
                { required: true, message: 'Korxona nomini tanlang', trigger: 'submit' },
              ]"
            >
              <el-select v-model="edit.data.factory_id">
                <el-option
                  v-for="item in factories"
                  :key="item.id"
                  :label="item.name"
                  :value="item.id">
                </el-option>
              </el-select>
            </el-form-item>
          </el-col>
          <el-col :span="8">
            <el-form-item
              prop="currency_id"
              name="currency_id"
              label="Valyuta"
              :rules="[
                { required: true, message: 'Valyutani tanlang', trigger: 'submit' },
              ]"
            >
              <el-select v-model="edit.data.currency_id">
                <el-option
                  v-for="item in currencies"
                  :key="item.id"
                  :label="item.name"
                  :value="item.id">
                </el-option>
              </el-select>
            </el-form-item>
          </el-col>
          <el-col :span="8">
            <el-form-item
              name="date"
              prop="date"
              label="Jo'natilgan sana"
              :rules="[
                { required: true, message: 'Jo\'natilgan sanani kiriting', trigger: 'submit' },
              ]"
            >
              <el-date-picker :value-format="'yyyy-MM-dd'" :editable="false" type="date" v-model="edit.data.date"></el-date-picker>
            </el-form-item>
          </el-col>
          <el-col :span="12">
            <el-form-item
              name="weight"
              prop="weight"
              label="Jo'natilgan paxta og'irligi"
              :rules="[
                { required: true, message: 'Jo\'natilgan paxta tolasi og\'irligini kiriting', trigger: 'submit' },
              ]"
            >
              <el-input v-model="edit.data.weight"></el-input>
            </el-form-item>
          </el-col>
          <el-col :span="12">
            <el-form-item
              name="summ"
              prop="summ"
              label="Jo'natilgan paxta uchun to'lov qiymati"
              :rules="[
                { required: true, message: 'Jo\'natilgan paxta tolasi to\'lov qiymatini kiriting', trigger: 'submit' },
              ]"
            >
              <el-input v-model="edit.data.summ"></el-input>
            </el-form-item>
          </el-col>
          <el-col :span="8">
            <el-form-item
              name="by_bank"
              prop="by_bank"
              label="Bank orqali tushgan mablag'"
            >
              <el-input v-model="edit.data.by_bank"></el-input>
            </el-form-item>
          </el-col>
          <el-col :span="8">
            <el-form-item
              name="by_tax"
              prop="by_tax"
              label="Majburiy ijro orqali to'langan mablag'"
            >
              <el-input v-model="edit.data.by_tax"></el-input>
            </el-form-item>
          </el-col>
          <el-col :span="8">
            <el-form-item
              name="by_self_counting"
              prop="by_self_counting"
              label="O'zaro hisob-kitob orqali tushgan mablag'"
            >
              <el-input v-model="edit.data.by_self_counting"></el-input>
            </el-form-item>
          </el-col>
        </el-row>
        <el-form-item>
          <el-button type="primary" @click="updatePost('formEdit')">Qo'shish</el-button>
        </el-form-item>
      </el-form>
    </el-dialog>

  </div>
</template>

<template id="edit-cotton">
  <div>
    <el-collapse>
      <el-collapse-item title="Paxta momig'i uchun hisobot qo'shish" name="1">
        <el-form label-position="top" id="form" :model="formData" ref="form">
          <el-row :gutter="20">
            <el-col :span="8">
              <el-form-item
                prop="factory_id"
                name="factory_id"
                label="Korxona nomi"
                :rules="[
                  { required: true, message: 'Korxona nomini tanlang', trigger: 'submit' },
                ]"
              >
                <el-select v-model="formData.factory_id">
                  <el-option
                    v-for="item in factories"
                    :key="item.id"
                    :label="item.name"
                    :value="item.id">
                  </el-option>
                </el-select>
              </el-form-item>
            </el-col>
            <el-col :span="8">
              <el-form-item
                prop="currency_id"
                name="currency_id"
                label="Valyuta"
                :rules="[
                  { required: true, message: 'Valyutani tanlang', trigger: 'submit' },
                ]"
              >
                <el-select v-model="formData.currency_id">
                  <el-option
                    v-for="item in currencies"
                    :key="item.id"
                    :label="item.name"
                    :value="item.id">
                  </el-option>
                </el-select>
              </el-form-item>
            </el-col>
            <el-col :span="8">
              <el-form-item
                name="date"
                prop="date"
                label="Jo'natilgan sana"
                :rules="[
                  { required: true, message: 'Jo\'natilgan sanani kiriting', trigger: 'submit' },
                ]"
              >
                <el-date-picker :value-format="'yyyy-MM-dd'" :editable="false" type="date" v-model="formData.date"></el-date-picker>
              </el-form-item>
            </el-col>
            <el-col :span="12">
              <el-form-item
                name="weight"
                prop="weight"
                label="Jo'natilgan paxta momig'i og'irligi"
                :rules="[
                  { required: true, message: 'Jo\'natilgan paxta momig\'i og\'irligini kiriting', trigger: 'submit' },
                ]"
              >
                <el-input v-model="formData.weight"></el-input>
              </el-form-item>
            </el-col>
            <el-col :span="12">
              <el-form-item
                name="summ"
                prop="summ"
                label="Jo'natilgan paxta momig'i uchun to'lov qiymati"
                :rules="[
                  { required: true, message: 'Jo\'natilgan paxta momig\'i to\'lov qiymatini kiriting', trigger: 'submit' },
                ]"
              >
                <el-input v-model="formData.summ"></el-input>
              </el-form-item>
            </el-col>
            <el-col :span="8">
              <el-form-item
                name="by_bank"
                prop="by_bank"
                label="Bank orqali tushgan mablag'"
              >
                <el-input v-model="formData.by_bank"></el-input>
              </el-form-item>
            </el-col>
            <el-col :span="8">
              <el-form-item
                name="by_tax"
                prop="by_tax"
                label="Majburiy ijro orqali to'langan mablag'"
              >
                <el-input v-model="formData.by_tax"></el-input>
              </el-form-item>
            </el-col>
            <el-col :span="8">
              <el-form-item
                name="by_self_counting"
                prop="by_self_counting"
                label="O'zaro hisob-kitob orqali tushgan mablag'"
              >
                <el-input v-model="formData.by_self_counting"></el-input>
              </el-form-item>
            </el-col>
          </el-row>
          <el-form-item>
            <el-button type="primary" @click="submitForm('form')">Qo'shish</el-button>
          </el-form-item>
        </el-form>
      </el-collapse-item>
    </el-collapse>
    <div class="filter">
        <el-row :gutter="10">
          <el-col :span="6">
            <el-select clearable v-model="filter.factory_id" placeholder="Korxona nomi">
              <el-option
                v-for="item in factories"
                :key="item.id"
                :label="item.name"
                :value="item.id">
              </el-option>
            </el-select>
          </el-col>
          <el-col :span="8">
            <el-date-picker style="width: 100%" :picker-options="option" type="month" :value-format="'yyyy-MM-dd'" :editable="false" type="date" v-model="filter.start"></el-date-picker>
          </el-col>
          <el-col :span="8">
            <el-date-picker style="width: 100%" :picker-options="option" type="month" :value-format="'yyyy-MM-dd'" :editable="false" type="date" v-model="filter.end"></el-date-picker>
          </el-col>
          <el-col :span="2">
            <el-button @click="pageChange(1)" type="primary"><i class="fa fa-check" aria-hidden="true"></i></el-button>
          </el-col>
      </el-row>
    </div>
    <div v-if="post&&post.length>0">
      <el-table
        v-loading="loading"
        element-loading-text="Yuklanmoqda..."
        element-loading-spinner="el-icon-loading"
        element-loading-background="rgba(0, 0, 0, 0.8)"
        :data="post"
        style="width: 100%">
        <el-table-column
          type="index"
          :index="(index) => index + 1"
          width="50">
        </el-table-column>
        <el-table-column
          width="100"
          label="Nomi">
          <template slot-scope="scope">
            {{ scope.row.name }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="Oy/bosh deb qarzi">
          <template slot-scope="scope">
            {{ (scope.row.before_deb > 0) ? scope.row.before_deb : 0 }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="Oy/bosh deb haqqi">
          <template slot-scope="scope">
            {{ (scope.row.before_deb < 0) ? -scope.row.before_deb : 0 }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="Jo'n/paxta momig'i og'irligi">
          <template slot-scope="scope">
            {{ scope.row.weight }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="Jo'n/paxta momig'i narxi">
          <template slot-scope="scope">
            {{ scope.row.summ }}
          </template>
        </el-table-column>
        <el-table-column
          width="100"
          label="Valyuta nomi">
          <template slot-scope="scope">
            {{ getCurrency(scope.row.currency_id) }}
          </template>
        </el-table-column>
        <el-table-column
          label="Umumiy to'langan summa">
          <template slot-scope="scope">
            {{ scope.row.pay_summ }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="Bank orqali to'langan">
          <template slot-scope="scope">
            {{ scope.row.by_bank }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="Majburiy undirish orqali to'langan">
          <template slot-scope="scope">
            {{ scope.row.by_tax }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="O'zaro hisob-kitob">
          <template slot-scope="scope">
            {{ scope.row.by_self_counting }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="Joriy vaqtdagi qarzi">
          <template slot-scope="scope">
            {{ (scope.row.current_deb > 0) ? scope.row.current_deb : 0 }}
          </template>
        </el-table-column>
        <el-table-column
          width="120"
          label="Joriy vaqtdagi haqqi">
          <template slot-scope="scope">
            {{ (scope.row.current_deb < 0) ? -scope.row.current_deb : 0 }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="To'lov sanasi">
          <template slot-scope="scope">
            {{ scope.row.date | moment('DD/MM/YYYY') }}
          </template>
        </el-table-column>
        <el-table-column
          width="70"
          fixed="right"
          align="center">
          <template slot-scope="scope">
            <el-button
              size="mini"
              @click="editPost(scope.row.id)"><i class="fa fa-pencil" aria-hidden="true"></i></el-button>
          </template>
        </el-table-column>
        <el-table-column
          width="60"
          fixed="right"
          align="right">
          <template slot-scope="scope">
            <el-button
              size="mini"
              type="danger"
              @click="deletePost(scope.row.id)"><i class="fa fa-trash" aria-hidden="true"></i></el-button>
          </template>
        </el-table-column>
      </el-table>
      <el-pagination
        v-if="total > limit"
        class="post-pagination"
        background
        :page-size="limit"
        :current-page.sync="offset"
        @current-change="pageChange" 
        layout="prev, pager, next"
        :total="total">
      </el-pagination>
    </div>

    <el-dialog title="Tahrirlash" :visible.sync="edit.editDialogVisible">
      <el-form label-position="top" id="formEdit" :model="edit.data" ref="formEdit">
        <el-row :gutter="20">
          <el-col :span="8">
            <el-form-item
              prop="factory_id"
              name="factory_id"
              label="Korxona nomi"
              :rules="[
                { required: true, message: 'Korxona nomini tanlang', trigger: 'submit' },
              ]"
            >
              <el-select v-model="edit.data.factory_id">
                <el-option
                  v-for="item in factories"
                  :key="item.id"
                  :label="item.name"
                  :value="item.id">
                </el-option>
              </el-select>
            </el-form-item>
          </el-col>
          <el-col :span="8">
            <el-form-item
              prop="currency_id"
              name="currency_id"
              label="Valyuta"
              :rules="[
                { required: true, message: 'Valyutani tanlang', trigger: 'submit' },
              ]"
            >
              <el-select v-model="edit.data.currency_id">
                <el-option
                  v-for="item in currencies"
                  :key="item.id"
                  :label="item.name"
                  :value="item.id">
                </el-option>
              </el-select>
            </el-form-item>
          </el-col>
          <el-col :span="8">
            <el-form-item
              name="date"
              prop="date"
              label="Jo'natilgan sana"
              :rules="[
                { required: true, message: 'Jo\'natilgan sanani kiriting', trigger: 'submit' },
              ]"
            >
              <el-date-picker :value-format="'yyyy-MM-dd'" :editable="false" type="date" v-model="edit.data.date"></el-date-picker>
            </el-form-item>
          </el-col>
          <el-col :span="12">
            <el-form-item
              name="weight"
              prop="weight"
              label="Jo'natilgan paxta momig'i og'irligi"
              :rules="[
                { required: true, message: 'Jo\'natilgan paxta momig\'i og\'irligini kiriting', trigger: 'submit' },
              ]"
            >
              <el-input v-model="edit.data.weight"></el-input>
            </el-form-item>
          </el-col>
          <el-col :span="12">
            <el-form-item
              name="summ"
              prop="summ"
              label="Jo'natilgan paxta uchun to'lov qiymati"
              :rules="[
                { required: true, message: 'Jo\'natilgan paxta momig\'i to\'lov qiymatini kiriting', trigger: 'submit' },
              ]"
            >
              <el-input v-model="edit.data.summ"></el-input>
            </el-form-item>
          </el-col>
          <el-col :span="8">
            <el-form-item
              name="by_bank"
              prop="by_bank"
              label="Bank orqali tushgan mablag'"
            >
              <el-input v-model="edit.data.by_bank"></el-input>
            </el-form-item>
          </el-col>
          <el-col :span="8">
            <el-form-item
              name="by_tax"
              prop="by_tax"
              label="Majburiy ijro orqali to'langan mablag'"
            >
              <el-input v-model="edit.data.by_tax"></el-input>
            </el-form-item>
          </el-col>
          <el-col :span="8">
            <el-form-item
              name="by_self_counting"
              prop="by_self_counting"
              label="O'zaro hisob-kitob orqali tushgan mablag'"
            >
              <el-input v-model="edit.data.by_self_counting"></el-input>
            </el-form-item>
          </el-col>
        </el-row>
        <el-form-item>
          <el-button type="primary" @click="updatePost('formEdit')">Qo'shish</el-button>
        </el-form-item>
      </el-form>
    </el-dialog>

  </div>
</template>

<template id="edit-other">
    <div>
        boshqalar-tahrirlash
    </div>
</template>

<template id="add-report">
  <div>
    <el-collapse>
      <el-collapse-item title="Chiqim uchun hisobot qo'shish" name="1">
        <el-form label-position="top" id="form" :model="formData" ref="form">
          <el-row :gutter="20">
            <el-col :span="8">
              <el-form-item
                prop="charges_type_id"
                name="charges_type_id"
                label="Chiqim turi"
                :rules="[
                  { required: true, message: 'Chiqim turini tanlang', trigger: 'submit' },
                ]"
              >
                <el-select v-model="formData.charges_type_id">
                  <el-option
                    v-for="item in charges_types"
                    :key="item.id"
                    :label="item.name"
                    :value="item.id">
                  </el-option>
                </el-select>
              </el-form-item>
            </el-col>
            <el-col :span="8">
              <el-form-item
                prop="currency_id"
                name="currency_id"
                label="Valyuta"
                :rules="[
                  { required: true, message: 'Valyutani tanlang', trigger: 'submit' },
                ]"
              >
                <el-select v-model="formData.currency_id">
                  <el-option
                    v-for="item in currencies"
                    :key="item.id"
                    :label="item.name"
                    :value="item.id">
                  </el-option>
                </el-select>
              </el-form-item>
            </el-col>
            <el-col :span="8">
              <el-form-item
                name="date"
                prop="date"
                label="Jo'natilgan sana"
                :rules="[
                  { required: true, message: 'Jo\'natilgan sanani kiriting', trigger: 'submit' },
                ]"
              >
                <el-date-picker :value-format="'yyyy-MM-dd'" :editable="false" type="date" v-model="formData.date"></el-date-picker>
              </el-form-item>
            </el-col>
            <el-col :span="12">
              <el-form-item
                name="output_summ"
                prop="output_summ"
                label="Mablag' summasi"
                :rules="[
                  { required: true, message: 'Mablag\' summasini kiriting', trigger: 'submit' },
                ]"
              >
                <el-input v-model="formData.output_summ"></el-input>
              </el-form-item>
            </el-col>
            <el-col :span="12">
              <el-form-item
                name="description"
                label="Izoh"
              >
                <el-input v-model="formData.description"></el-input>
              </el-form-item>
            </el-col>
          </el-row>
          <el-form-item>
            <el-button type="primary" @click="submitForm('form')">Qo'shish</el-button>
          </el-form-item>
        </el-form>
      </el-collapse-item>
    </el-collapse>
    <div class="filter">
        <el-row :gutter="10">
          <el-col :span="6">
            <el-select clearable v-model="filter.charges_type_id" placeholder="Chiqim turi">
              <el-option
                v-for="item in charges_types"
                :key="item.id"
                :label="item.name"
                :value="item.id">
              </el-option>
            </el-select>
          </el-col>
          <el-col :span="8">
            <el-date-picker style="width: 100%" :picker-options="option" type="month" :value-format="'yyyy-MM-dd'" :editable="false" type="date" v-model="filter.start"></el-date-picker>
          </el-col>
          <el-col :span="8">
            <el-date-picker style="width: 100%" :picker-options="option" type="month" :value-format="'yyyy-MM-dd'" :editable="false" type="date" v-model="filter.end"></el-date-picker>
          </el-col>
          <el-col :span="2">
            <el-button @click="pageChange(1)" type="primary"><i class="fa fa-check" aria-hidden="true"></i></el-button>
          </el-col>
      </el-row>
    </div>
    <div v-if="post&&post.length>0">
      <el-table
        v-loading="loading"
        element-loading-text="Yuklanmoqda..."
        element-loading-spinner="el-icon-loading"
        element-loading-background="rgba(0, 0, 0, 0.8)"
        :data="post"
        style="width: 100%">
        <el-table-column
          type="index"
          :index="(index) => index + 1"
          width="50">
        </el-table-column>
        <el-table-column
          label="Nomi">
          <template slot-scope="scope">
            {{ scope.row.name }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="Jo'n/paxta narxi">
          <template slot-scope="scope">
            {{ scope.row.output_summ }}
          </template>
        </el-table-column>
        <el-table-column
          width="100"
          label="Valyuta nomi">
          <template slot-scope="scope">
            {{ getCurrency(scope.row.currency_id) }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="To'lov sanasi">
          <template slot-scope="scope">
            {{ scope.row.date | moment('DD/MM/YYYY') }}
          </template>
        </el-table-column>
        <el-table-column
          width="70"
          fixed="right"
          align="center">
          <template slot-scope="scope">
            <el-button
              size="mini"
              @click="editPost(scope.row.id)"><i class="fa fa-pencil" aria-hidden="true"></i></el-button>
          </template>
        </el-table-column>
        <el-table-column
          width="60"
          fixed="right"
          align="right">
          <template slot-scope="scope">
            <el-button
              size="mini"
              type="danger"
              @click="deletePost(scope.row.id)"><i class="fa fa-trash" aria-hidden="true"></i></el-button>
          </template>
        </el-table-column>
      </el-table>
      <el-pagination
        v-if="total > limit"
        class="post-pagination"
        background
        :page-size="limit"
        :current-page.sync="offset"
        @current-change="pageChange" 
        layout="prev, pager, next"
        :total="total">
      </el-pagination>
    </div>

    <el-dialog title="Tahrirlash" :visible.sync="edit.editDialogVisible">
      <el-form label-position="top" id="formEdit" :model="edit.data" ref="formEdit">
        <el-row :gutter="20">
          <el-col :span="8">
            <el-form-item
              prop="charges_type_id"
              name="charges_type_id"
              label="Chiqim turi"
              :rules="[
                { required: true, message: 'Chiqim turini tanlang', trigger: 'submit' },
              ]"
            >
              <el-select v-model="edit.data.charges_type_id">
                <el-option
                  v-for="item in charges_types"
                  :key="item.id"
                  :label="item.name"
                  :value="item.id">
                </el-option>
              </el-select>
            </el-form-item>
          </el-col>
          <el-col :span="8">
            <el-form-item
              prop="currency_id"
              name="currency_id"
              label="Valyuta"
              :rules="[
                { required: true, message: 'Valyutani tanlang', trigger: 'submit' },
              ]"
            >
              <el-select v-model="edit.data.currency_id">
                <el-option
                  v-for="item in currencies"
                  :key="item.id"
                  :label="item.name"
                  :value="item.id">
                </el-option>
              </el-select>
            </el-form-item>
          </el-col>
          <el-col :span="8">
            <el-form-item
              name="date"
              prop="date"
              label="Jo'natilgan sana"
              :rules="[
                { required: true, message: 'Jo\'natilgan sanani kiriting', trigger: 'submit' },
              ]"
            >
              <el-date-picker :value-format="'yyyy-MM-dd'" :editable="false" type="date" v-model="edit.data.date"></el-date-picker>
            </el-form-item>
          </el-col>
          <el-col :span="12">
            <el-form-item
              name="output_summ"
              prop="output_summ"
              label="Mablag' summasi"
              :rules="[
                { required: true, message: 'Mablag\' summasini kiriting', trigger: 'submit' },
              ]"
            >
              <el-input v-model="edit.data.output_summ"></el-input>
            </el-form-item>
          </el-col>
          <el-col :span="12">
            <el-form-item
              name="description"
              label="Izoh"
            >
              <el-input v-model="edit.data.description"></el-input>
            </el-form-item>
          </el-col>
        </el-row>
        <el-form-item>
          <el-button type="primary" @click="updatePost('formEdit')">Qo'shish</el-button>
        </el-form-item>
      </el-form>
    </el-dialog>

  </div>
</template>

<!-- Statistics -->
<template id="statistics-staple">
  <div>
    <div class="filter">
        <el-row :gutter="10">
          <el-col :span="2">
            <el-checkbox-button :checked="filter.one_filter" v-model="filter.one_filter"><i class="el-icon-view"></i></el-checkbox-button>
          </el-col>
          <el-col :span="6">
            <el-select clearable v-model="filter.factory_id" placeholder="Korxona nomi">
              <el-option
                v-for="item in factories"
                :key="item.id"
                :label="item.name"
                :value="item.id">
              </el-option>
            </el-select>
          </el-col>
          <el-col :span="7">
            <el-date-picker style="width: 100%" :picker-options="option" type="month" :value-format="'yyyy-MM-dd'" :editable="false" type="date" v-model="filter.start"></el-date-picker>
          </el-col>
          <el-col :span="7">
            <el-date-picker style="width: 100%" :picker-options="option" type="month" :value-format="'yyyy-MM-dd'" :editable="false" type="date" v-model="filter.end"></el-date-picker>
          </el-col>
          <el-col :span="2">
            <el-button @click="pageChange(1)" type="primary"><i class="fa fa-check" aria-hidden="true"></i></el-button>
          </el-col>
      </el-row>
    </div>
    <div v-if="post&&post.length>0">
      <el-table
        v-loading="loading"
        element-loading-text="Yuklanmoqda..."
        element-loading-spinner="el-icon-loading"
        element-loading-background="rgba(0, 0, 0, 0.8)"
        :data="post"
        style="width: 100%">
        <el-table-column
          type="index"
          :index="(index) => index + 1"
          width="50">
        </el-table-column>
        <el-table-column
          width="100"
          label="Nomi">
          <template slot-scope="scope">
            {{ scope.row.name }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="Oy/bosh deb qarzi">
          <template slot-scope="scope">
            {{ (scope.row.before_deb > 0) ? scope.row.before_deb : 0 }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="Oy/bosh deb haqqi">
          <template slot-scope="scope">
            {{ (scope.row.before_deb < 0) ? -scope.row.before_deb : 0 }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="Jo'n/paxta tolasi og'irligi">
          <template slot-scope="scope">
            {{ scope.row.weight }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="Jo'n/paxta narxi">
          <template slot-scope="scope">
            {{ scope.row.summ }}
          </template>
        </el-table-column>
        <el-table-column
          width="100"
          label="Valyuta nomi">
          <template slot-scope="scope">
            {{ getCurrency(scope.row.currency_id) }}
          </template>
        </el-table-column>
        <el-table-column
          label="Umumiy to'langan summa">
          <template slot-scope="scope">
            {{ scope.row.pay_summ }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="Bank orqali to'langan">
          <template slot-scope="scope">
            {{ scope.row.by_bank }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="Majburiy undirish orqali to'langan">
          <template slot-scope="scope">
            {{ scope.row.by_tax }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="O'zaro hisob-kitob">
          <template slot-scope="scope">
            {{ scope.row.by_self_counting }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="Joriy vaqtdagi qarzi">
          <template slot-scope="scope">
            {{ (scope.row.current_deb > 0) ? scope.row.current_deb : 0 }}
          </template>
        </el-table-column>
        <el-table-column
          width="120"
          label="Joriy vaqtdagi haqqi">
          <template slot-scope="scope">
            {{ (scope.row.current_deb < 0) ? -scope.row.current_deb : 0 }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="To'lov sanasi">
          <template slot-scope="scope">
            {{ scope.row.date | moment('DD/MM/YYYY') }}
          </template>
        </el-table-column>
      </el-table>
      <el-pagination
        v-if="total > limit"
        class="post-pagination"
        background
        :page-size="limit"
        :current-page.sync="offset"
        @current-change="pageChange" 
        layout="prev, pager, next"
        :total="total">
      </el-pagination>
    </div>
  </div>
</template>

<template id="statistics-corn">
  <div>
    <div class="filter">
        <el-row :gutter="10">
          <el-col :span="2">
            <el-checkbox-button :checked="filter.one_filter" v-model="filter.one_filter"><i class="el-icon-view"></i></el-checkbox-button>
          </el-col>
          <el-col :span="6">
            <el-select clearable v-model="filter.factory_id" placeholder="Korxona nomi">
              <el-option
                v-for="item in factories"
                :key="item.id"
                :label="item.name"
                :value="item.id">
              </el-option>
            </el-select>
          </el-col>
          <el-col :span="7">
            <el-date-picker style="width: 100%" :picker-options="option" type="month" :value-format="'yyyy-MM-dd'" :editable="false" type="date" v-model="filter.start"></el-date-picker>
          </el-col>
          <el-col :span="7">
            <el-date-picker style="width: 100%" :picker-options="option" type="month" :value-format="'yyyy-MM-dd'" :editable="false" type="date" v-model="filter.end"></el-date-picker>
          </el-col>
          <el-col :span="2">
            <el-button @click="pageChange(1)" type="primary"><i class="fa fa-check" aria-hidden="true"></i></el-button>
          </el-col>
      </el-row>
    </div>
    <div v-if="post&&post.length>0">
      <el-table
        v-loading="loading"
        element-loading-text="Yuklanmoqda..."
        element-loading-spinner="el-icon-loading"
        element-loading-background="rgba(0, 0, 0, 0.8)"
        :data="post"
        style="width: 100%">
        <el-table-column
          type="index"
          :index="(index) => index + 1"
          width="50">
        </el-table-column>
        <el-table-column
          width="100"
          label="Nomi">
          <template slot-scope="scope">
            {{ scope.row.name }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="Oy/bosh deb qarzi">
          <template slot-scope="scope">
            {{ (scope.row.before_deb > 0) ? scope.row.before_deb : 0 }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="Oy/bosh deb haqqi">
          <template slot-scope="scope">
            {{ (scope.row.before_deb < 0) ? -scope.row.before_deb : 0 }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="Tasdiqlangan dislokatsiya rejasi">
          <template slot-scope="scope">
            {{ (scope.row.corn_dislocation[0])?scope.row.corn_dislocation[0].weight:'Belgilanmagan' }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="Jo'n/texnik chigit og'irligi">
          <template slot-scope="scope">
            {{ scope.row.weight }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="Jo'n/paxta narxi">
          <template slot-scope="scope">
            {{ scope.row.summ }}
          </template>
        </el-table-column>
        <el-table-column
          width="100"
          label="Valyuta nomi">
          <template slot-scope="scope">
            {{ getCurrency(scope.row.currency_id) }}
          </template>
        </el-table-column>
        <el-table-column
          label="Umumiy to'langan summa">
          <template slot-scope="scope">
            {{ scope.row.pay_summ }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="Bank orqali to'langan">
          <template slot-scope="scope">
            {{ scope.row.by_bank }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="Majburiy undirish orqali to'langan">
          <template slot-scope="scope">
            {{ scope.row.by_tax }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="O'zaro hisob-kitob">
          <template slot-scope="scope">
            {{ scope.row.by_self_counting }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="Joriy vaqtdagi qarzi">
          <template slot-scope="scope">
            {{ (scope.row.current_deb > 0) ? scope.row.current_deb : 0 }}
          </template>
        </el-table-column>
        <el-table-column
          width="120"
          label="Joriy vaqtdagi haqqi">
          <template slot-scope="scope">
            {{ (scope.row.current_deb < 0) ? -scope.row.current_deb : 0 }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="To'lov sanasi">
          <template slot-scope="scope">
            {{ scope.row.date | moment('DD/MM/YYYY') }}
          </template>
        </el-table-column>
      </el-table>
      <el-pagination
        v-if="total > limit"
        class="post-pagination"
        background
        :page-size="limit"
        :current-page.sync="offset"
        @current-change="pageChange" 
        layout="prev, pager, next"
        :total="total">
      </el-pagination>
    </div>
  </div>
</template>

<template id="statistics-cotton">
  <div>
    <div class="filter">
        <el-row :gutter="10">
          <el-col :span="2">
            <el-checkbox-button :checked="filter.one_filter" v-model="filter.one_filter"><i class="el-icon-view"></i></el-checkbox-button>
          </el-col>
          <el-col :span="6">
            <el-select clearable v-model="filter.factory_id" placeholder="Korxona nomi">
              <el-option
                v-for="item in factories"
                :key="item.id"
                :label="item.name"
                :value="item.id">
              </el-option>
            </el-select>
          </el-col>
          <el-col :span="7">
            <el-date-picker style="width: 100%" :picker-options="option" type="month" :value-format="'yyyy-MM-dd'" :editable="false" type="date" v-model="filter.start"></el-date-picker>
          </el-col>
          <el-col :span="7">
            <el-date-picker style="width: 100%" :picker-options="option" type="month" :value-format="'yyyy-MM-dd'" :editable="false" type="date" v-model="filter.end"></el-date-picker>
          </el-col>
          <el-col :span="2">
            <el-button @click="pageChange(1)" type="primary"><i class="fa fa-check" aria-hidden="true"></i></el-button>
          </el-col>
      </el-row>
    </div>
    <div v-if="post&&post.length>0">
      <el-table
        v-loading="loading"
        element-loading-text="Yuklanmoqda..."
        element-loading-spinner="el-icon-loading"
        element-loading-background="rgba(0, 0, 0, 0.8)"
        :data="post"
        style="width: 100%">
        <el-table-column
          type="index"
          :index="(index) => index + 1"
          width="50">
        </el-table-column>
        <el-table-column
          width="100"
          label="Nomi">
          <template slot-scope="scope">
            {{ scope.row.name }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="Oy/bosh deb qarzi">
          <template slot-scope="scope">
            {{ (scope.row.before_deb > 0) ? scope.row.before_deb : 0 }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="Oy/bosh deb haqqi">
          <template slot-scope="scope">
            {{ (scope.row.before_deb < 0) ? -scope.row.before_deb : 0 }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="Jo'n/paxta momig'i og'irligi">
          <template slot-scope="scope">
            {{ scope.row.weight }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="Jo'n/paxta momig'i narxi">
          <template slot-scope="scope">
            {{ scope.row.summ }}
          </template>
        </el-table-column>
        <el-table-column
          width="100"
          label="Valyuta nomi">
          <template slot-scope="scope">
            {{ getCurrency(scope.row.currency_id) }}
          </template>
        </el-table-column>
        <el-table-column
          label="Umumiy to'langan summa">
          <template slot-scope="scope">
            {{ scope.row.pay_summ }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="Bank orqali to'langan">
          <template slot-scope="scope">
            {{ scope.row.by_bank }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="Majburiy undirish orqali to'langan">
          <template slot-scope="scope">
            {{ scope.row.by_tax }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="O'zaro hisob-kitob">
          <template slot-scope="scope">
            {{ scope.row.by_self_counting }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="Joriy vaqtdagi qarzi">
          <template slot-scope="scope">
            {{ (scope.row.current_deb > 0) ? scope.row.current_deb : 0 }}
          </template>
        </el-table-column>
        <el-table-column
          width="120"
          label="Joriy vaqtdagi haqqi">
          <template slot-scope="scope">
            {{ (scope.row.current_deb < 0) ? -scope.row.current_deb : 0 }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="To'lov sanasi">
          <template slot-scope="scope">
            {{ scope.row.date | moment('DD/MM/YYYY') }}
          </template>
        </el-table-column>
      </el-table>
      <el-pagination
        v-if="total > limit"
        class="post-pagination"
        background
        :page-size="limit"
        :current-page.sync="offset"
        @current-change="pageChange" 
        layout="prev, pager, next"
        :total="total">
      </el-pagination>
    </div>
  </div>
</template>

<template id="statistics-other">
    <div>
        boshqalar-hisobot
    </div>
</template>

<template id="statistics-charges">
  <div>
    <div class="filter">
        <el-row :gutter="10">
          <el-col :span="2">
            <el-checkbox-button :checked="filter.one_filter" v-model="filter.one_filter"><i class="el-icon-view"></i></el-checkbox-button>
          </el-col>
          <el-col :span="6">
            <el-select clearable v-model="filter.charges_type_id" placeholder="Chiqim turi">
              <el-option
                v-for="item in charges_types"
                :key="item.id"
                :label="item.name"
                :value="item.id">
              </el-option>
            </el-select>
          </el-col>
          <el-col :span="7">
            <el-date-picker style="width: 100%" :picker-options="option" type="month" :value-format="'yyyy-MM-dd'" :editable="false" type="date" v-model="filter.start"></el-date-picker>
          </el-col>
          <el-col :span="7">
            <el-date-picker style="width: 100%" :picker-options="option" type="month" :value-format="'yyyy-MM-dd'" :editable="false" type="date" v-model="filter.end"></el-date-picker>
          </el-col>
          <el-col :span="2">
            <el-button @click="pageChange(1)" type="primary"><i class="fa fa-check" aria-hidden="true"></i></el-button>
          </el-col>
      </el-row>
    </div>
    <div v-if="post&&post.length>0">
      <el-table
        v-loading="loading"
        element-loading-text="Yuklanmoqda..."
        element-loading-spinner="el-icon-loading"
        element-loading-background="rgba(0, 0, 0, 0.8)"
        :data="post"
        style="width: 100%">
        <el-table-column
          type="index"
          :index="(index) => index + 1"
          width="50">
        </el-table-column>
        <el-table-column
          label="Nomi">
          <template slot-scope="scope">
            {{ scope.row.name }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="Jo'n/paxta narxi">
          <template slot-scope="scope">
            {{ scope.row.output_summ }}
          </template>
        </el-table-column>
        <el-table-column
          width="100"
          label="Valyuta nomi">
          <template slot-scope="scope">
            {{ getCurrency(scope.row.currency_id) }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="To'lov sanasi">
          <template slot-scope="scope">
            {{ scope.row.date | moment('DD/MM/YYYY') }}
          </template>
        </el-table-column>
        <el-table-column
          width="130"
          label="Qisqa izoh">
          <template slot-scope="scope">
            <el-popover trigger="hover" placement="top">
              <div slot="reference">
                {{ (scope.row.description)?scope.row.description.slice(0, 20):'' }}
              </div>
              <p>{{ scope.row.description }}</p>
            </el-popover>
          </template>
        </el-table-column>
      </el-table>
      <el-pagination
        v-if="total > limit"
        class="post-pagination"
        background
        :page-size="limit"
        :current-page.sync="offset"
        @current-change="pageChange" 
        layout="prev, pager, next"
        :total="total">
      </el-pagination>
    </div>

  </div>
</template>

<!-- Options -->

<template id="options-factory">
  <div>
    <el-collapse>
      <el-collapse-item title="Korxona qo'shish" name="1">
        <el-form label-position="top" id="form" :model="formData" ref="form">
          <el-row :gutter="20">
            <el-col :span="12">
              <el-form-item
                prop="name"
                name="name"
                label="Korxona nomi"
                :rules="[
                  { required: true, message: 'Korxona nomini kiriting', trigger: 'submit' },
                ]"
              >
                <el-input v-model="formData.name"></el-input>
              </el-form-item>
            </el-col>
            <el-col :span="12">
              <el-form-item
                name="phone"
                prop="phone"
                label="Telefon raqami"
                :rules="[]"
              >
                <el-input v-model="formData.phone"></el-input>
              </el-form-item>
            </el-col>
          </el-row>         
          <el-form-item
            name="address"
            prop="address"
            label="Korxona manzili"
          >
            <el-input v-model="formData.address"></el-input>
          </el-form-item>
          <el-form-item
            name="info"
            prop="info"
            label="Qo'shimcha ma'lumot"
          >
            <el-input type="textarea" v-model="formData.info"></el-input>
          </el-form-item>
          <el-form-item>
            <el-button type="primary" @click="submitForm('form')">Qo'shish</el-button>
          </el-form-item>
        </el-form>
      </el-collapse-item>
    </el-collapse>
    <div class="filter">
        <el-row :gutter="10">
          <el-col :span="24">
            <el-input clerable @change.native="pageChange(1)" v-model="filter.name"></el-input>
          </el-col>
      </el-row>
    </div>
    <div v-if="post&&post.length>0">
      <el-table
        v-loading="loading"
        element-loading-text="Yuklanmoqda..."
        element-loading-spinner="el-icon-loading"
        element-loading-background="rgba(0, 0, 0, 0.8)"
        :data="post"
        style="width: 100%">
        <el-table-column
          type="index"
          :index="(index) => index + 1"
          width="50">
        </el-table-column>
        <el-table-column
          label="Nomi">
          <template slot-scope="scope">
            {{ scope.row.name }}
          </template>
        </el-table-column>
        <el-table-column
          width="70"
          align="center">
          <template slot-scope="scope">
            <el-button
              size="mini"
              @click="editPost(scope.row.id)"><i class="fa fa-pencil" aria-hidden="true"></i></el-button>
          </template>
        </el-table-column>
        <el-table-column
          width="60"
          align="right">
          <template slot-scope="scope">
            <el-button
              size="mini"
              type="danger"
              @click="deletePost(scope.row.id)"><i class="fa fa-trash" aria-hidden="true"></i></el-button>
          </template>
        </el-table-column>
      </el-table>
      <el-pagination
        v-if="total > limit"
        class="post-pagination"
        background
        :page-size="limit"
        :current-page.sync="offset"
        @current-change="pageChange" 
        layout="prev, pager, next"
        :total="total">
      </el-pagination>
    </div>

    <el-dialog title="Tahrirlash" :visible.sync="edit.editDialogVisible">
      <el-form label-position="top" id="formEdit" :model="edit.data" ref="formEdit">
        <el-row :gutter="20">
          <el-col :span="12">
            <el-form-item
              prop="name"
              name="name"
              label="Korxona nomi"
              :rules="[
                { required: true, message: 'Korxona nomini kriting', trigger: 'submit' },
              ]"
            >
              <el-input v-model="edit.data.name"></el-input>
            </el-form-item>
          </el-col>
          <el-col :span="12">
            <el-form-item
              name="phone"
              prop="phone"
              label="Telefon raqami"
            >
              <el-input v-model="edit.data.phone"></el-input>
            </el-form-item>
          </el-col>
        </el-row>
        <el-form-item
          name="address"
          prop="address"
          label="Korxona manzili"
        >
          <el-input v-model="edit.data.address"></el-input>
        </el-form-item>
        <el-form-item
          name="info"
          prop="info"
          label="Qo'shimcha ma'lumot"
        >
          <el-input type="textarea" v-model="edit.data.info"></el-input>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="updatePost('formEdit')">Qo'shish</el-button>
        </el-form-item>
      </el-form>
    </el-dialog>

  </div>
</template>

<template id="options-currency">
  <div>
    <el-collapse>
      <el-collapse-item title="Valyuta qo'shish" name="1">
        <el-form label-position="top" id="form" :model="formData" ref="form">
          <el-row :gutter="20">
            <el-col :span="12">
              <el-form-item
                prop="name"
                name="name"
                label="Valyuta nomi"
                :rules="[
                  { required: true, message: 'Valyuta nomini kiriting', trigger: 'submit' },
                ]"
              >
                <el-input v-model="formData.name"></el-input>
              </el-form-item>
            </el-col>
            <el-col :span="12">
              <el-form-item
                name="code"
                prop="code"
                label="Valyuta kodi"
              >
                <el-input v-model="formData.code"></el-input>
              </el-form-item>
            </el-col>
          </el-row>
          <el-form-item>
            <el-button type="primary" @click="submitForm('form')">Qo'shish</el-button>
          </el-form-item>
        </el-form>
      </el-collapse-item>
    </el-collapse>

    <div v-if="post&&post.length>0">
      <el-table
        :data="post"
        style="width: 100%">
        <el-table-column
          type="index"
          :index="(index) => index + 1"
          width="50">
        </el-table-column>
        <el-table-column
          label="Nomi">
          <template slot-scope="scope">
            {{ scope.row.name }}
          </template>
        </el-table-column>
        <el-table-column
          width="70"
          align="center">
          <template slot-scope="scope">
            <el-button
              size="mini"
              @click="editPost(scope.row.id)"><i class="fa fa-pencil" aria-hidden="true"></i></el-button>
          </template>
        </el-table-column>
        <el-table-column
          width="60"
          align="right">
          <template slot-scope="scope">
            <el-button
              size="mini"
              type="danger"
              @click="deletePost(scope.row.id)"><i class="fa fa-trash" aria-hidden="true"></i></el-button>
          </template>
        </el-table-column>
      </el-table>
      <el-pagination
        v-if="total > limit"
        class="post-pagination"
        background
        :page-size="limit"
        :current-page.sync="offset"
        @current-change="pageChange" 
        layout="prev, pager, next"
        :total="total">
      </el-pagination>
    </div>

    <el-dialog title="Tahrirlash" :visible.sync="edit.editDialogVisible">
      <el-form label-position="top" id="formEdit" :model="edit.data" ref="formEdit">
        <el-row :gutter="20">
          <el-col :span="12">
            <el-form-item
              prop="name"
              name="name"
              label="Valyuta nomi"
              :rules="[
                { required: true, message: 'Valyuta nomini kiriting', trigger: 'submit' },
              ]"
            >
              <el-input v-model="edit.data.name"></el-input>
            </el-form-item>
          </el-col>
          <el-col :span="12">
            <el-form-item
              name="code"
              prop="code"
              label="Valyuta kodi"
            >
              <el-input v-model="edit.data.code"></el-input>
            </el-form-item>
          </el-col>
        </el-row>
        <el-form-item>
          <el-button type="primary" @click="updatePost('formEdit')">Qo'shish</el-button>
        </el-form-item>
      </el-form>
    </el-dialog>

  </div>
</template>

<template id="options-charges">
    <div>
    <el-collapse>
      <el-collapse-item title="Chiqim turini qo'shish" name="1">
        <el-form label-position="top" id="form" :model="formData" ref="form">
          <el-form-item
            prop="name"
            name="name"
            label="Chiqim turi"
            :rules="[
              { required: true, message: 'Chiqim turini kiriting', trigger: 'submit' },
            ]"
          >
            <el-input v-model="formData.name"></el-input>
          </el-form-item>
          <el-form-item>
            <el-button type="primary" @click="submitForm('form')">Qo'shish</el-button>
          </el-form-item>
        </el-form>
      </el-collapse-item>
    </el-collapse>

    <div v-if="post&&post.length>0">
      <el-table
        :data="post"
        style="width: 100%">
        <el-table-column
          type="index"
          :index="(index) => index + 1"
          width="50">
        </el-table-column>
        <el-table-column
          label="Nomi">
          <template slot-scope="scope">
            {{ scope.row.name }}
          </template>
        </el-table-column>
        <el-table-column
          width="70"
          align="center">
          <template slot-scope="scope">
            <el-button
              size="mini"
              @click="editPost(scope.row.id)"><i class="fa fa-pencil" aria-hidden="true"></i></el-button>
          </template>
        </el-table-column>
        <el-table-column
          width="60"
          align="right">
          <template slot-scope="scope">
            <el-button
              size="mini"
              type="danger"
              @click="deletePost(scope.row.id)"><i class="fa fa-trash" aria-hidden="true"></i></el-button>
          </template>
        </el-table-column>
      </el-table>
      <el-pagination
        v-if="total > limit"
        class="post-pagination"
        background
        :page-size="limit"
        :current-page.sync="offset"
        @current-change="pageChange" 
        layout="prev, pager, next"
        :total="total">
      </el-pagination>
    </div>

    <el-dialog title="Tahrirlash" :visible.sync="edit.editDialogVisible">
      <el-form label-position="top" id="formEdit" :model="edit.data" ref="formEdit">
        <el-form-item
          prop="name"
          name="name"
          label="Chiqim turi"
          :rules="[
            { required: true, message: 'Chiqim turini kriting', trigger: 'submit' },
          ]"
        >
          <el-input v-model="edit.data.name"></el-input>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="updatePost('formEdit')">Qo'shish</el-button>
        </el-form-item>
      </el-form>
    </el-dialog>

  </div>
</template>

<template id="options-dislocation">
  <div>
    <el-collapse>
      <el-collapse-item title="Chigit uchun tasdiqlangan oylik dislokatsiyasi qo'shish" name="1">
        <el-form label-position="top" id="form" :model="formData" ref="form">
          <el-row :gutter="20">
            <el-col :span="8">
              <el-form-item
                prop="factory_id"
                name="factory_id"
                label="Korxona nomi"
                :rules="[
                  { required: true, message: 'Korxona nomini tanlang', trigger: 'submit' },
                ]"
              >
                <el-select v-model="formData.factory_id">
                  <el-option
                    v-for="item in factories"
                    :key="item.id"
                    :label="item.name"
                    :value="item.id">
                  </el-option>
                </el-select>
              </el-form-item>
            </el-col>
            <el-col :span="8">
              <el-form-item
                name="weight"
                prop="weight"
                label="Og'irligi(tonna)"
                :rules="[
                  { required: true, message: 'Tasdiqlangan dislokatsiya rejasini kriting', trigger: 'submit' },
                ]"
              >
                <el-input v-model="formData.weight"></el-input>
              </el-form-item>
            </el-col>
            <el-col :span="8">
              <el-form-item
                name="date"
                prop="date"
                label="Tasdiqlangan oy"
                :rules="[
                  { required: true, message: 'Tasdiqlangan oyni kiriting', trigger: 'submit' },
                ]"
              >
                <el-date-picker type="month" :value-format="'yyyy-MM-dd'" :editable="false" type="date" v-model="formData.date"></el-date-picker>
              </el-form-item>
            </el-col>
          </el-row>
          <el-form-item>
            <el-button type="primary" @click="submitForm('form')">Qo'shish</el-button>
          </el-form-item>
        </el-form>
      </el-collapse-item>
    </el-collapse>
    <div class="filter">
        <el-row :gutter="10">
          <el-col :span="6">
            <el-select clearable v-model="filter.factory_id" placeholder="Korxona nomi">
              <el-option
                v-for="item in factories"
                :key="item.id"
                :label="item.name"
                :value="item.id">
              </el-option>
            </el-select>
          </el-col>
          <el-col :span="8">
            <el-date-picker style="width: 100%" :picker-options="option" type="month" :value-format="'yyyy-MM-dd'" :editable="false" type="date" v-model="filter.start"></el-date-picker>
          </el-col>
          <el-col :span="8">
            <el-date-picker style="width: 100%" :picker-options="option" type="month" :value-format="'yyyy-MM-dd'" :editable="false" type="date" v-model="filter.end"></el-date-picker>
          </el-col>
          <el-col :span="2">
            <el-button @click="pageChange(1)" type="primary"><i class="fa fa-check" aria-hidden="true"></i></el-button>
          </el-col>
      </el-row>
    </div>
    <div v-if="post&&post.length>0">
      <el-table
        v-loading="loading"
        element-loading-text="Yuklanmoqda..."
        element-loading-spinner="el-icon-loading"
        element-loading-background="rgba(0, 0, 0, 0.8)"
        :data="post"
        style="width: 100%">
        <el-table-column
          type="index"
          :index="(index) => index + 1"
          width="50">
        </el-table-column>
        <el-table-column
          label="Nomi">
          <template slot-scope="scope">
            {{ scope.row.name }}
          </template>
        </el-table-column>
        <el-table-column
          label="Og'irligi(tonna)">
          <template slot-scope="scope">
            {{ scope.row.weight }}
          </template>
        </el-table-column>
        <el-table-column
          label="Tasdiqlangan oy">
          <template slot-scope="scope">
            {{ scope.row.date | moment('MM/YYYY') }}
          </template>
        </el-table-column>
        <el-table-column
          width="70"
          align="center">
          <template slot-scope="scope">
            <el-button
              size="mini"
              @click="editPost(scope.row.id)"><i class="fa fa-pencil" aria-hidden="true"></i></el-button>
          </template>
        </el-table-column>
        <el-table-column
          width="60"
          align="right">
          <template slot-scope="scope">
            <el-button
              size="mini"
              type="danger"
              @click="deletePost(scope.row.id)"><i class="fa fa-trash" aria-hidden="true"></i></el-button>
          </template>
        </el-table-column>
      </el-table>
      <el-pagination
        v-if="total > limit"
        class="post-pagination"
        background
        :page-size="limit"
        :current-page.sync="offset"
        @current-change="pageChange" 
        layout="prev, pager, next"
        :total="total">
      </el-pagination>
    </div>

    <el-dialog title="Tahrirlash" :visible.sync="edit.editDialogVisible">
      <el-form label-position="top" id="formEdit" :model="edit.data" ref="formEdit">
        <el-row :gutter="20">
          <el-col :span="8">
            <el-form-item
              prop="factory_id"
              name="factory_id"
              label="Korxona nomi"
              :rules="[
                { required: true, message: 'Korxona nomini tanlang', trigger: 'submit' },
              ]"
            >
              <el-select v-model="edit.data.factory_id">
                <el-option
                  v-for="item in factories"
                  :key="item.id"
                  :label="item.name"
                  :value="item.id">
                </el-option>
              </el-select>
            </el-form-item>
          </el-col>
          <el-col :span="8">
            <el-form-item
              name="weight"
              prop="weight"
              label="Og'irligi(tonna)"
              :rules="[
                { required: true, message: 'Tasdiqlangan dislokatsiya rejasini kriting', trigger: 'submit' },
              ]"
            >
              <el-input v-model="edit.data.weight"></el-input>
            </el-form-item>
          </el-col>
          <el-col :span="8">
            <el-form-item
              name="date"
              prop="date"
              label="Tasdiqlangan oy"
              :rules="[
                { required: true, message: 'Tasdiqlangan oyni kiriting', trigger: 'submit' },
              ]"
              >
              <el-date-picker type="month" :format="'yyyy-MM'" :value-format="'yyyy-MM-dd'" :editable="false" type="date" v-model="edit.data.date"></el-date-picker>
            </el-form-item>
          </el-col>
        </el-row>
        <el-form-item>
          <el-button type="primary" @click="updatePost('formEdit')">Qo'shish</el-button>
        </el-form-item>
      </el-form>
    </el-dialog>

  </div>
</template>