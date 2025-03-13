// IMPORT
import { z } from 'zod';
import { ref } from 'vue';

// EXPORT (variables)
export const modalToggle = ref(false);
export const modalToggleDefault = ref(false);
export const modalFormData = ref({
    citation_number: '',
    status: '',
    violator: {
        first_name: '',
        middle_name: '',
        last_name: '',
        gender_id: '',
    },
});
export const modalFormDataDefault = ref({
    citation_number: '',
    status: '',
    violator: {
        first_name: '',
        middle_name: '',
        last_name: '',
        gender_id: '',
    },
});
export const modalFormCNMaxLength = 13;
export const modalFormSchema = z.object({
    citation_number: z.string().regex(/^\d{3}-\d{4}-\d{4}$/, "Use format XXX-XXXX-XXXX"),
    status: z.string(),
    violator: z.object({
        first_name: z.string().min(1),
        middle_name: z.string().optional(), 
        last_name: z.string().optional(),
        gender_id: z.number(),
    }),
});

// OTHER
type FormSchema = z.output<typeof modalFormSchema>