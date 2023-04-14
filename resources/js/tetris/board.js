import { COLS, BLOCK_SIZE, ROWS } from "./constants";

export class Board {
    constructor() {
      this.piece = null;
    }

    // Сбрасывает игровое поле перед началом новой игры
    reset() {
      this.grid = this.getEmptyBoard();
    }

    // Создает матрицу нужного размера, заполненную нулями
    getEmptyBoard() {
      return Array.from(
        {length: ROWS}, () => Array(COLS).fill(0)
      );
    }
  }
