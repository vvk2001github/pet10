import { COLS, ROWS } from "./constants";
import { Piece } from "./piece";

export class Board {
    ctx;
    piece;

    constructor(ctx) {
      this.piece = null;
      this.ctx = ctx;
    }



    // Создает матрицу нужного размера, заполненную нулями
    getEmptyBoard() {
      return Array.from(
        {length: ROWS}, () => Array(COLS).fill(0)
      );
    }

    valid(p) {
        return p.shape.every((row, dy) => {
            return row.every((value, dx) => {
              let x = p.x + dx;
              let y = p.y + dy;
              return value === 0 ||
                  (this.insideWalls(x) && this.aboveFloor(y) && this.notOccupied(x, y));
            });
        });
    }

    insideWalls(x) {
        return x >= 0 && x < COLS;
    }

    aboveFloor(y) {
        return y <= ROWS;
    }

      // не занята ли клетка поля другими фигурками
    notOccupied(x, y) {
        return this.grid[y] && this.grid[y][x] === 0;
    }

    // Сбрасывает игровое поле перед началом новой игры
    reset() {
        this.grid = this.getEmptyBoard();
        this.piece = new Piece(this.ctx);
        this.piece.setStartingPosition();
    }

    rotate(piece) {

        // Clone with JSON for immutability.
        let p = JSON.parse(JSON.stringify(piece));

        // Transpose matrix
        for (let y = 0; y < p.shape.length; ++y) {
            for (let x = 0; x < y; ++x) {
                [p.shape[x][y], p.shape[y][x]] = [p.shape[y][x], p.shape[x][y]];
            }
        }

        // Reverse the order of the columns.
        p.shape.forEach(row => row.reverse());

        return p;
    }
  }
