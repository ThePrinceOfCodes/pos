export interface CartItem {
  index?: number;
  id?: number;
  name: string;
  price: number;
  quantity: number;
  stock?: number;
  category?: number;
}

export interface ReceiptDetails {
  id?: number;
  name: string;
  email?: string;
  branch_id?: number;
  salesId?: number;
  company_name: string;
  company_email: string;
  company_address: string;
  company_phone: number;
  trans_ref: number;
}

export interface User {
  id: number;
  name: string;
  salesId: number;
}
