<template>
  <div>
    <h1 class="text-center">Gestionar Articulos Admin</h1>
    <hr />

    <!-- Button to Open the Modal -->
    <button
      @click="
        modificar = false;
        abrirModal();
      "
      type="button"
      class="btn btn-primary my-4"
    >
      Nuevo
    </button>

    <!-- The Modal -->
    <div class="modal" :class="{ mostrar: modal }">
      <div class="modal-dialog">
        <div class="modal-content">
          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">{{ tituloModal }}</h4>
            <button
              @click="cerrarModal()"
              type="button"
              class="close"
              data-dismiss="modal"
            >
              &times;
            </button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <div class="my-4">
              <label for="nombre">Nombre</label>
              <input
                v-model="articulo.nombre"
                type="text"
                class="form-control"
                id="nombre"
                placeholder="Nombre del Articulo"
              />
              <span class="text-danger" v-if="errores.nombre">{{
                errores.nombre[0]
              }}</span>
            </div>
            <div class="my-4">
              <label for="descripcion">descripcion</label>
              <input
                v-model="articulo.descripcion"
                type="text"
                class="form-control"
                id="descripcion"
                placeholder="Descripcion del Articulo"
              />
              <span class="text-danger" v-if="errores.nombre">{{
                errores.descripcion[0]
              }}</span>
            </div>
            <div class="my-4">
              <label for="stock">stock</label>
              <input
                v-model="articulo.stock"
                type="number"
                class="form-control"
                id="stock"
                placeholder="Stock del Articulo"
              />
              <span class="text-danger" v-if="errores.stock">{{
                errores.stock[0]
              }}</span>
            </div>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button
              @click="cerrarModal()"
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
            >
              Cancelar
            </button>
            <button
              @click="guardar()"
              type="button"
              class="btn btn-success"
              data-dismiss="modal"
            >
              Guardar
            </button>
          </div>
        </div>
      </div>
    </div>

    <table class="table table-striped">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Nombre</th>
          <th scope="col">Descripcion</th>
          <th scope="col">Stock</th>
          <th scope="col" colspan="2" class="text-center">Accion</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="art in articulos.data" :key="art.id">
          <th scope="row">{{ art.id }}</th>
          <td>{{ art.nombre }}</td>
          <td>{{ art.descripcion }}</td>
          <td>{{ art.stock }}</td>
          <td>
            <button
              @click="
                modificar = true;
                abrirModal(art);
              "
              class="btn btn-success"
            >
              Editar
            </button>
          </td>
          <td>
            <button @click="eliminar(art.id)" class="btn btn-danger">
              Eliminar
            </button>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="row">
    
      <div class="col-6 md-6">
        <nav aria-label="Page navigation example">
          <ul class="pagination">
            <li class="page-item" :class="{disabled:paginacion.page==1}"><a class="page-link" href="#" @click="paginacion.page=1, listar()">&laquo;</a></li>
             <li class="page-item" :class="{disabled:paginacion.page==1}"><a class="page-link" href="#" @click="paginacion.page--, listar()">&lt;</a></li>
              <li class="page-item" v-for="n in articulos.last_page" :key="n" :class="{disabled:paginacion.page==n}"><a class="page-link" href="#" @click="paginacion.page=n, listar()">{{n}}</a></li>
               <li class="page-item" :class="{disabled:paginacion.page==articulo.last_page}"><a class="page-link" href="#" @click="paginacion.page++, listar()">&gt;</a></li>
                <li class="page-item" :class="{disabled:paginacion.page==articulo.last_page}"><a class="page-link" href="#" @click="paginacion.page=articulo.last_page, listar()">&raquo;</a></li>
          </ul>
        </nav>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      articulo: {
        nombre: "aa",
        descripcion: "aa",
        stock: 1,
      },
      id: 0,
      modificar: true,
      modal: 0,
      tituloModal: "",
      articulos: [],
      errores: {},
      paginacion: {
        page: 1,
        per_page: 5,
      },
    };
  },
  methods: {
    async listar() {
      const res = await axios.get("/articulos", { params: this.paginacion });
      this.articulos = res.data;
    },
    async eliminar(id) {
      const res = await axios.delete("/articulos/" + id);
      this.listar();
    },
    async guardar() {
      try {
        if (this.modificar) {
          const res = await axios.put("/articulos/" + this.id, this.articulo);
          /* console.log(this.id); */
        } else {
          const res = await axios.post("/articulos/", this.articulo);
        }
        this.cerrarModal();
        this.listar();
      } catch (error) {
        if (error.response.data) {
          this.errores = error.response.data.errors;
        }
      }
    },
    abrirModal(data = {}) {
      this.modal = 1;
      if (this.modificar) {
        this.id = data.id;
        this.tituloModal = "Modificar Articulo";
        this.articulo.nombre = data.nombre;
        this.articulo.descripcion = data.descripcion;
        this.articulo.stock = data.stock;
      } else {
        this.id = 0;
        this.tituloModal = "Crear Articulo";
        this.articulo.nombre = "";
        this.articulo.descripcion = "";
        this.articulo.stock = 1;
      }
    },
    cerrarModal() {
      this.modal = 0;
      this.errors = {};
    },
  },
  created() {
    this.listar();
  },
};
</script>

<style>
.mostrar {
  display: list-item;
  opacity: 1;
  background: rgba(75, 56, 143, 0.705);
}
</style>